<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Job;
use frontend\models\Analytics;
use frontend\models\Application;
use common\models\User;
use frontend\models\JobSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * JobController implements the CRUD actions for Job model.
 */
class JobController extends Controller
{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Job models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new JobSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Job model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionApply($id,$user) {

        $app = new Application();
        $job = Job::findOne($id);

        $apps = Application::find()->orderBy('id')->all();
            if (count($apps) == 0) {
                $app->id = 0;
            }
            else {
                $highestID = $apps[count($apps)-1];
                $app->id = $highestID->id+1;
            }
        $app->user_id = $user;
        $app->company_id = $job->company_id;
        $app->job_id = $id;
        $app->state = "Gespeichert";
        $app->save();
        return $this->render('applied');
    }

    /**
     * Creates a new Job model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Job();
        $thisUser = Yii::$app->getUser();
        $model->contact_id = $thisUser->id;
        $getUser = User::findOne($thisUser->id);
        $model->company_id = $getUser->company_id;
        Yii::trace('User ID: ' .Yii::$app->user->getId());
        Yii::trace('Comp ID: ' .$getUser->company_id);

        $jobs = Job::find()->orderBy('id')->all();
            if (count($jobs) == 0) {
                $model->id = 0;
            }
            else {
                $highestID = $jobs[count($jobs)-1];
                $model->id = $highestID->id+1;
            }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionGenerateBtn($id) {

        $thisUser = Yii::$app->getUser();
        $getUser = User::findOne($thisUser->id);

        $model = $this->findModel($id);

        $html = '<xmp><iframe src="http://frontend/job/iframe" width="100" height="50" id="hireMeFrame" frameBorder="0" name="'.$model->id.'">
        </iframe></xmp>';

        return $this->render('btnview', [
         'iframe' => $html,
        ]);
  
    }   

    public function actionIframe() {

        $cookie = Yii::$app->request->cookies['usr_']->value;

         return $this->renderPartial('iframe',[
            'userID' => $cookie,
            ]);
    }

    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Job model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Job the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Job::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

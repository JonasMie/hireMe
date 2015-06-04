<?php

namespace frontend\controllers;

use common\behaviours\BodyClassBehaviour;
use Yii;
use frontend\models\Job;
use frontend\models\Company;
use frontend\models\Analytics;
use frontend\models\Application;
use common\models\User;
use frontend\models\JobSearch;
use frontend\models\ApplyBtn;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;

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
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
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

    public function actionMyJobs($companyId) {

         $comp = Company::getNameById($companyId);
        
        // For displaying applier data
        $analytics = new Analytics();
        $allJobs = $analytics->getJobs($companyId);
        Yii::trace("Jobs: ".count($allJobs));
        $applierArray = [];

        for ($i=0; $i <count($allJobs) ; $i++) { 
            $jobApplier = count($analytics->getAppliesForJob($allJobs[$i]->id));
            Yii::trace("Applier: ".$jobApplier);
            $applierArray[$i] = $jobApplier;
        }


        $dataProvider = new ActiveDataProvider([
        'query' => Job::find(['company_id' => $companyId]),
        'pagination' => [
            'pageSize' => 20,]
        ]);


       return $this->render('_myjobs', [
            'companyName' => $comp,
            'applierArray' => $applierArray,
            'provider' => $dataProvider,
        ]);

    }

    public function actionApply($key,$user,$case) {

        if ($case == 0) {
 
        }

        else {

        $app = new Application();

        $apps = Application::find()->orderBy('id')->all();
            if (count($apps) == 0) {
                $app->id = 0;
            }
            else {
                $highestID = $apps[count($apps)-1];
                $app->id = $highestID->id+1;
            }
    

      $thisBtn = ApplyBtn::find()
        ->where(['key' => $key])
        ->one();
        

        $job = Job::find()->where(['id' => $thisBtn->job_id])->one();
        Yii::trace("Job ID: ".$job->id);
        $app->user_id = $user;
        $app->company_id = $job->company_id;
        $app->job_id = $job->id;
        $app->state = "Gespeichert";
        $app->btn_id = $thisBtn->id;
        $app->save();
        return $this->render('applied');

        }

    }

    // count views
    public function actionViewUp($btnKey) {

        $btn = ApplyBtn::find()
        ->where(['key' => $btnKey])
        ->one();
        $btn->viewCount = $btn->viewCount+1;
        $btn->save();
    }

    //count clicks
    public function actionClickUp($btnKey) {
        
        $btn = ApplyBtn::find()
        ->where(['key' => $btnKey])
        ->one();

        $btn->clickCount = $btn->clickCount+1;
        $btn->save();

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
        $getUser = User::findOne($thisUser->id);
        Yii::trace('User ID: ' .Yii::$app->user->getId());
        if ($getUser->is_recruiter ==1) {
        $model->company_id = $getUser->company_id;            
        Yii::trace('Comp ID: ' .$getUser->company_id);
        }
       

        $jobs = Job::find()->orderBy('id')->all();
            if (count($jobs) == 0) {
                $model->id = 0;
            }
            else {
                $highestID = $jobs[count($jobs)-1];
                $model->id = $highestID->id+1;
            }
        $model->time = 0;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        Yii::trace("kjashd");
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    private function keyGeneration($keyBase) {

       $key = md5(uniqid($keyBase, true));

       $btns = ApplyBtn::find()->orderBy('id')->all();
        for ($i=0; $i < count($btns); $i++) { 
        
            if ($key == $btns[$i]->key ) {
                $this->$keyGeneration($keyBase);
            }
            
        }

        return $key;
    }

    public function actionGenerateBtn($id,$site) {

        $thisUser = Yii::$app->getUser();
        $getUser = User::findOne($thisUser->id);

        $model = $this->findModel($id);

        $btnId;

         $btns = ApplyBtn::find()->orderBy('id')->all();
            if (count($btns) == 0) {
                $btnId = 0;
            }
            else {

                $highestID = $btns[count($btns)-1];
                $btnId = $highestID->id+1;
            }
        $keyBase = $model->id.'_'.$btnId;
        $key = $this->keyGeneration($keyBase);

        $btn = new ApplyBtn();
        $btn->id = $btnId;
        $btn->job_id = $id;
        $btn->key = $key;
        $btn->site = $site;
        $btn->clickCount = 0;
        $btn->viewCount = 0;
        $btn->save();

        return $this->render('btnview', [
         'iframe' => $key,
        ]);
  
    }   

    public function actionViewCount() {


         return $this->renderPartial('viewCountIFrame');
    }

    public function actionButtonPopup() {

        $cookie = Yii::$app->request->cookies['usr_']->value;

         return $this->renderPartial('buttonPopup',[
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

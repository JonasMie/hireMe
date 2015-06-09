<?php

namespace frontend\Controllers;

use common\behaviours\BodyClassBehaviour;
use Yii;
use frontend\models\Application;
use frontend\models\ApplicationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\Controllers\JobController;
use frontend\models\Job;
use frontend\models\ApplicationData;
use frontend\models\File;
use frontend\models\UploadForm;
use yii\web\UploadedFile;

/**
 * ApplicationController implements the CRUD actions for Application model.
 */
class ApplicationController extends Controller
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
     * Lists all Application models.
     * @return mixed
     */
    
    public function actionIndex()
    {
        $searchModel = new ApplicationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($jobId)
    {
        $user = Yii::$app->user->identity;

        $job = Job::findOne($jobId);

        $app = new Application();

        $apps = Application::find()->orderBy('id')->all();
            if (count($apps) == 0) {
                $app->id = 0;
            }
            else {
                $highestID = $apps[count($apps)-1];
                $app->id = $highestID->id+1;
            }

        $app->user_id = $user->id;
        $app->company_id = $job->company_id;
        $app->job_id = $jobId;
     //   $app->state = "Gespeichert";
        $model = new UploadForm();

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) { 

                $file = new File();

                $files = File::find()->orderBy('id')->all();
                if (count($files) == 0) $file->id = 0;
                else { 
                $highestID = $files[count($files)-1];
                $file->id = $highestID->id+1;
                }
                $name = "AP_".uniqid();             
                $file->path = "assets/uploads/ad/";
                $file->extension = $model->file->extension;
                $file->size = $model->file->size;
                $file->title = $model->title;
                Yii::trace("Titel: ".$model->title);
                $file->save();
                $model->file->saveAs('assets/uploads/ad/' . $name . '.' . $model->file->extension);
            }
        }

        if ($app->load(Yii::$app->request->post()) && $app->save()) {
            return $this->redirect(['view', 'id' => $app->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
                'job' => $job,
            ]);
        }
    }
    /**
     * Updates an existing Application model.
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
     * Deletes an existing Application model.
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
     * Finds the Application model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Application the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Application::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

<?php

namespace frontend\controllers;

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
use yii\data\ActiveDataProvider;
use frontend\models\ApplicationDataSearch;
use common\models\User;
use yii\data\SqlDataProvider;
use yii\db\Query;
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
    public function getJobTitle($id) { //expecting job id

        $job = Job::findOne($id);
        return $job->title;

    }

    public function getApplierName($id) { // expecting user id

        $user = User::findOne($id);
        return $user->firstName." ".$user->lastName; 
    }

    public function actionShowFile($id) {

        $appData = ApplicationData::find()
        ->where(['id' => $id])->one();
        Yii::trace("file id: ".$appData->file_id);

        $file = File::find()
        ->where(["id" => $appData->file_id])->one();
        Yii::trace("file title: ".$file->title);

        $app = Application::find()
        ->where(['id' => $appData->application_id])->one();
        Yii::trace("app user: ".$app->user_id);

        $user_id = $app->user_id;


        $this->redirect("http://frontend/uploads/appData/AD_".md5($user_id.'_'.$appData->file_id).'.'.$file->extension);
        
    }
    
    public function actionIndex($new=null)
    {

        if (Yii::$app->user->identity->isRecruiter()) {
        
        $companyId = Yii::$app->user->identity->getCompanyId();
        Yii::trace("Company ID: ".$companyId);
        // For displaying applier data
    

        $applications = new ApplicationSearch(); 
        $sql = "SELECT j.title, a.id, u.fullName,u.userName from job j ,user u ,application a, company d where a.job_id = j.id and a.company_id = j.company_id and a.user_id = u.id and a.company_id = d.id and a.sent = 1 and d.id = ".Yii::$app->user->identity->company_id;
        $indiTitle = "Alle Bewerbungen";
        
        if ($new != null) {
        $sql = "SELECT j.title, a.id, u.fullName,u.userName from job j ,user u ,application a, company d where a.job_id = j.id and a.company_id = j.company_id and a.user_id = u.id and a.company_id = d.id and a.sent = 1 and a.read = 0 and d.id = ".Yii::$app->user->identity->company_id;
        $indiTitle = "Neue Bewerbungen";
        }
       
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'sort' => [
                'attributes' => [
                'title','fullName'
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,
                'fullName' => SORT_ASC
            ]
            ],
        ]);

        Yii::trace("Company: ".$companyId);
       return $this->render('index', [
            'id' => $companyId,
            'title' => $indiTitle,
            'provider' => $dataProvider,
        ]);

     } 

     else {

        $applications = new ApplicationSearch();        
        $savedProvider = $applications->search(['ApplicationSearch' =>['user_id' => Yii::$app->user->identity->id,'state' => 'Gespeichert']]);
        $sentProvider = $applications->search(['ApplicationSearch' =>['user_id' => Yii::$app->user->identity->id,'state' => 'Versendet']]);

       return $this->render('index', [
            'savedProvider' => $savedProvider,
            'sentProvider' => $sentProvider,
        ]);

        }
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $app = Application::findOne($id);
        $user = User::find()->where(['id' => $app->user_id])->one();
        Yii::trace($user->fullName);
        $created = $app->created_at;
        $model["app"] = $app;
        $model["user"] = $user;
        $model["created"] = $app->created_at;
        
        $appDatas = new ApplicationDataSearch();
        $provider = $appDatas->search(['ApplicationDataSearch' => ['application_id' => $app->id]]);
       
        return $this->render('view', [
            'model' => $model,
            'appDataProvider' => $provider,

        ]);
    }

    public function actionDataHandler($id,$appID,$direction) { // expects app data id.

        Yii::trace("app id:".$appID);
        $appData = ApplicationData::findOne($id);
        // TODO: differenciate app ids
        Yii::trace("APP DATA FOR: ".$appData->application_id);
        $app = Application::findOne($appID);  
        if($appData->application_id != $app->id) {

            Yii::trace("noch nicht dafür hinzugefügt");

        }
        if($direction == 1) { $appData->sent = 1; }
        else { $appData->sent = 0; }
        $appData->save();

        $this->redirect("/application/add-data?id=".$appID);

    }

    /**
     * Creates a new Application model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionSend($id) {

        $app = Application::findOne($id);
        $app->state = "Versendet";
        $app->sent = 1;
        $app->save();

        $applications = new ApplicationSearch();        
        $savedProvider = $applications->search(['ApplicationSearch' =>['user_id' => Yii::$app->user->identity->id,'state' => 'Gespeichert']]);
        $sentProvider = $applications->search(['ApplicationSearch' =>['user_id' => Yii::$app->user->identity->id,'state' => 'Versendet']]);

       return $this->render('index', [
            'savedProvider' => $savedProvider,
            'sentProvider' => $sentProvider,
        ]);
    }

    public function actionAddData($id)
    {
        $user = Yii::$app->user->identity;

        $app = Application::findOne($id);
        $job = Job::findOne($app->job_id);
        
        $model = new UploadForm();
        $appDatas = new ApplicationDataSearch();

        $query = new Query;
        $newSQL = "SELECT f.title, ad.id, ad.application_id from file f, application_data ad, application a WHERE ad.application_id = a.id and f.id = ad.file_id and a.user_id = ".$user->id;
        Yii::trace("User ID: ".$user->id);
        $provider = new SqlDataProvider([
            'sql' => $newSQL,
            'sort' => [
                'attributes' => [
                'title'
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,
                
            ]
            ],
        ]);

        $dataSQL = "SELECT f.title, ad.id, ad.application_id from file f, application_data ad, application a WHERE ad.application_id = a.id and f.id = ad.file_id  and ad.sent = 1 and a.id = ".$app->id." and a.user_id = ".$user->id;
        $appDataProvider = new SqlDataProvider([
            'sql' => $dataSQL,
            'sort' => [
                'attributes' => [
                'title'
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,
                
            ]
            ],
        ]);

        if ($model->load(Yii::$app->request->post())) {

            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) { 

                $file = new File();
                // Firstly, create file, then reference it by application_data 
                $files = File::find()->orderBy('id')->all();
                $file->path = "uploads/appData/";
                $file->extension = $model->file->extension;
                $file->size = $model->file->size;
                $file->title = $model->title;
                if($file->save()) {
                $model->file->saveAs('uploads/appData/AD_' .md5($user->id.'_'.$file->id). '.' . $model->file->extension);                
                Yii::trace("Saved file");
                }

                $appData = new ApplicationData();
                $appDates = ApplicationData::find()->orderBy('id')->all();
                if (count($appDates) == 0) $appData->id = 0;
                else { 
                $highestID = $appDates[count($appDates)-1];
                $appData->id = $highestID->id+1;
                }

                $appData->application_id = $app->id;
                $appData->file_id = $file->id;
                $appData->sent = 0;

                if($appData->save()) {
                Yii::trace("Saved app data and application");
                }

                $this->renderPartial("uploadSection", ['model'=>$model,'provider' => $provider]);
            }
        }

        if ($app->load(Yii::$app->request->post()) && $app->save()) {
            return $this->redirect(['view', 'id' => $app->id]);

        } else {
            return $this->render('create', [
                'appId' => $id,
                'model' => $model,
                'job' => $job,
                'provider' => $provider,
                'appDataProvider' => $appDataProvider,
            ]);
        }
    }

    public static function getFileTitle($id) { //expected app data id

        $file = File::findOne($id);
        return $file->title;

    }

    public static function getFileExtension($id) { //expected app data id

        $file = File::findOne($id);
        return $file->extension;

    }

    public static function getUserIdFromAppData($id) {

        $app = Application::find()
        ->where(['id' => $id])->one();
        return $app->user_id;

    }

    public function actionUpdateApplicationData() {

    $appDatas = new ApplicationDataSearch();
    $provider = $appDatas->search(['ApplicationDataSearch']);
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

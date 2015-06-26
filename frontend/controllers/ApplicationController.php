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
use frontend\models\Message;
use frontend\models\CoverCreateForm;
use frontend\models\ResumeSchoolSearch;
use frontend\models\ResumeJobSearch;
use frontend\models\ResumeJob;
use frontend\models\ResumeSchool;
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

    public static function getApplicationDataForJob($id) {

       $sql = "SELECT u.fullName, u.id from user u, application a WHERE a.job_id = ".$id." and u.id = a.user_id";
       
       $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'sort' => [
                'attributes' => [
                'fullName'
            ],
            'defaultOrder' => [
                'fullName' => SORT_ASC
            ]
            ],
        ]);

       return $dataProvider;

    }

    public function getApplierName($id) { // expecting user id

        $user = User::findOne($id);
        return $user->firstName." ".$user->lastName; 
    }

     public function actionShowFile($id,$isReport=false) {

        $file = File::find()
        ->where(["id" => $id])->one();
        Yii::trace("file title: ".$file->title);
        $user_id = $file->user_id;
        
        $this->redirect("/uploads".$file->path.'.'.$file->extension);
        
    }
    
    public function actionIndex($new=null)
    {

        if (Yii::$app->user->identity->isRecruiter()) {
        
        $companyId = Yii::$app->user->identity->getCompanyId();
        Yii::trace("Company ID: ".$companyId);
        // For displaying applier data


    

        $applications = new ApplicationSearch(); 
        $sql = "SELECT j.title, j.id as jobID, a.created_at, a.id, u.fullName,u.userName, u.id as userID from job j ,user u ,application a, company d where a.job_id = j.id and a.company_id = j.company_id and a.user_id = u.id and a.company_id = d.id and a.sent = 1 and a.archived = 0 and d.id = ".Yii::$app->user->identity->company_id;
        $indiTitle = "Alle Bewerbungen";
        
        if ($new != null) {
        $sql = "SELECT j.title, j.id as jobID, a.created_at, a.id, u.fullName,u.userName, u.id as userID from job j ,user u ,application a, company d where a.job_id = j.id and a.company_id = j.company_id and a.user_id = u.id and a.company_id = d.id and a.sent = 1 and a.archived = 0 and a.read = 0 and d.id = ".Yii::$app->user->identity->company_id;
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
        Yii::trace("Bewerbung: ".$app->id);
        $applier = User::find()->where(['id' => $app->user_id])->one();
        Yii::trace($applier->fullName);
        $created = $app->created_at;

        $schools = new ResumeSchoolSearch();
        $schoolProvider = $schools->search(['ResumeSchoolSearch' => ['user_id' => $applier->id]]);

        $jobs = new ResumeJobSearch();
        $jobProvider = $jobs->search(['ResumeJobSearch' => ['user_id' => $applier->id]]);
        
        $currentJob = ResumeJob::find()
        ->where(['user_id' => $applier->id,'current' => 1])->one();
        if(count($currentJob) == 0) {
        $currentJob = ResumeJob::find()
        ->where(['user_id' => $applier->id])->one();
        }
        

        $appDatas = new ApplicationDataSearch();
        $provider = $appDatas->search(['ApplicationDataSearch' => ['application_id' => $app->id]]);
        if (Yii::$app->user->identity->isRecruiter()) {

        Yii::trace($applier->id);
        $model["app"] = $app;
        $model["user"] = $applier;
        $model["created"] = $app->created_at;
        $model["job"] = Job::find()->where(['id' => $app->job_id])->one();
        $model["coverText"] = file_get_contents('uploads/covers/COVER_' .md5($applier->id.'_'.$app->id). '.txt');          

          return $this->render('view', [
            'model' => $model,
            'appDataProvider' => $provider,
            'schoolProvider' => $schoolProvider,
            'jobProvider' => $jobProvider,
            'currentJob' => $currentJob,

        ]);
        }
        else {

        $model["job"] = Job::find()->where(['id' => $app->job_id])->one();
        $model["created"] = $app->created_at;
        $model["coverText"] = file_get_contents('uploads/covers/COVER_' .md5($applier->id.'_'.$app->id). '.txt');          

        return $this->render('view', [
            'model' => $model,
            'appDataProvider' => $provider,

        ]);

        }
       
    }

    public function actionAppAction($app,$act) {
        $user = Yii::$app->user->identity;
        $app = Application::findOne($app);
        $job = Job::find()->where(['id' => $app->job_id])->one();

        $message = new Message();
        $message->subject = "Deine Bewerbung auf: ".$job->title;
        $message->sender_id = $user->id;
        $message->receiver_id = $app->user_id;

        if($act == 0) {
            // Invite for talk
            $app->state = "Vorstellungsgespräch";
            if($app->save()) {
            $this->redirect("/application");
            }

        }   

        else if ($act == 1) {
            // Hire directly

        $message->content = "Herzlichen Glückwunsch! Soeben wurdest du von ".$user->fullName. " für den Job ". $job->title." eingestellt.";
        if($message->save()) {
            $this->redirect("/application");
        }
        }
        else {
            //Archived application :(
        $app->archived = 1;
        if($app->save()) {
            $message->content = "Hey do Loser, du warst einfach zu schlecht, hab die Bewerbung sofort gelöscht.... Du penner!";
            if($message->save()) {
            $this->redirect("/application");
            }
        }
      }

    }

    public function actionDataHandler($id,$appID,$direction) { // expects app data id.

        Yii::trace("file id:".$id);
        $app = Application::findOne($appID);

       if($direction == 1) {   
        $appData = new ApplicationData();

         $appDatas = ApplicationData::find()->orderBy('id')->all();
            if (count($appDatas) == 0) {
                $appData->id = 0;
            }
            else {
                $highestID = $appDatas[count($appDatas)-1];
                $appData->id = $highestID->id+1;
            } 

        $appData->application_id = $appID;
        $appData->file_id = $id;
        $appData->save();
       }
       else {
        $appData = ApplicationData::findOne($id);
        $appData->delete();
       }
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

        $newSQL = "SELECT f.title, f.id from file f WHERE NOT (f.title LIKE '%cover%') AND f.user_id = ".$user->id;
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

        $sentSQL = "SELECT f.title, ad.id from file f, application_data ad, application a WHERE a.user_id = ".$user->id." and ad.application_id = a.id and ad.file_id = f.id and a.id =".$id;
        $sentProvider = new SqlDataProvider([
            'sql' => $sentSQL,
            'sort' => [
                'attributes' => [
                'title'
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,   
            ]
            ],
        ]);

        $model = new CoverCreateForm();
        $model->app = $app->id;
        $possibleFile = File::find()
        ->where(['title' => 'cover_'.$app->id,'user_id' => $user->id])->one();

        if (count($possibleFile) ==1) {

            $model->text = file_get_contents('uploads'.$possibleFile->path.'.txt');          
        }

            return $this->render('create', [
                'model' => $model,
                'appId' => $id,
                'job' => $job,
                'provider' => $provider,
                'sentProvider' => $sentProvider
            ]);
    }

    public function actionSaveCover() {

         if (Yii::$app->request->isAjax) {

              $model = new CoverCreateForm();
              $model->app = Yii::$app->request->get('app');
              $text = Yii::$app->request->get('text');
              $model->text = $text;
              if($model->create() == true) {
                return "Deine Bewerbung wurde gespeichert.";
              }
              else {
                return "Leider gab es einen Fehler beim Speichern der Bewerbung.";
              }
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

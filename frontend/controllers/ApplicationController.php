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

       $sql = "SELECT u.fullName, u.id from user u, application a WHERE a.job_id = ".$id." and u.id = a.user_id and a.state = 'Versendet'";
       
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
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if (Yii::$app->user->identity->isRecruiter()) {
        
        $companyId = Yii::$app->user->identity->getCompanyId();
        Yii::trace("Company ID: ".$companyId);
        // For displaying applier data


        $applications = new ApplicationSearch(); 
        $sql = "SELECT j.title, j.id as jobID, a.score, a.created_at, a.id , u.fullName,u.userName, u.id as userID from job j ,user u ,application a, company d where a.job_id = j.id and a.company_id = j.company_id and a.user_id = u.id and a.company_id = d.id and a.sent = 1 and a.archived = 0 and d.id = ".Yii::$app->user->identity->company_id;
        $indiTitle = "Alle Bewerbungen";
        
        if ($new != null) {
        $sql = "SELECT j.title, j.id as jobID, a.score,a.created_at, a.id , u.fullName,u.userName, u.id as userID from job j ,user u ,application a, company d where a.job_id = j.id and a.company_id = j.company_id and a.user_id = u.id and a.company_id = d.id and a.sent = 1 and a.archived = 0 and a.read = 0 and d.id = ".Yii::$app->user->identity->company_id;
        $indiTitle = "Neue Bewerbungen";
        }


       
        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'sort' => [
                'attributes' => [
                'title','fullName','score',
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,
                'fullName' => SORT_ASC,
                'score' => SORT_DESC,
            ]
            ],
        ]);

        Yii::trace("Company: ".$companyId);
       return $this->render('index', [
            'id' => $companyId,
            'title' => $indiTitle,
            'provider' => $dataProvider,
            'new' => $new,

        ]);

     } 

     else {
        
        $newSQL = "SELECT a.id, a.created_at, a.state, j.id as jobID from application a, job j WHERE a.job_id = j.id and a.state != 'Gespeichert' and a.user_id =".Yii::$app->user->identity->id;
        $sentProvider = new SqlDataProvider([
            'sql' => $newSQL,
            'sort' => [
                'attributes' => [
                'title','created_at','state'
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,   
                'created_at' => SORT_ASC,
            ]
            ],
        ]);

        $applications = new ApplicationSearch();        
        $savedProvider = $applications->search(['ApplicationSearch' =>['user_id' => Yii::$app->user->identity->id,'state' => 'Gespeichert']]);

       return $this->render('index', [
            'savedProvider' => $savedProvider,
            'sentProvider' => $sentProvider,
        ]);

        }
    }

    public function actionChangeScore() {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}
    if(Yii::$app->user->identity->isRecruiter()) {
          if (Yii::$app->request->isAjax) {
            $score = Yii::$app->request->get('score');
            $appID = Yii::$app->request->get('app');
            $app = Application::findOne($appID);
            $app->score = $score;
            $app->save();
        }
    }
    else {$this->redirect("/dashboard");}
    }

    /**
     * Displays a single Application model.
     * @param integer $id
     * @return mixed
     */

    public function actionView($id)
    {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

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
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        $user = Yii::$app->user->identity;

        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/application");}

        $app = Application::findOne($app);
        $job = Job::find()->where(['id' => $app->job_id])->one();

        $message = new Message();
        $message->subject = "Deine Bewerbung als: ".$job->title;
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
        $app->state="Absage";
        if($app->save()) {
            $message->content = "Leider hat sich das Unternehmen nicht für deine Bewerbung entschieden.";
            if($message->save()) {
            $this->redirect("/application");
            }
        }
      }

    }

    public function actionDataHandler($id,$appID,$direction) { // expects app data id.
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

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
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

        $app = Application::findOne($id);
        $app->state = "Versendet";
        $app->sent = 1;
        $app->save();

        $newSQL = "SELECT a.id, a.created_at, a.state, j.id as jobID from application a, job j WHERE a.job_id = j.id and a.state != 'Gespeichert' and a.user_id =".Yii::$app->user->identity->id;
        $sentProvider = new SqlDataProvider([
            'sql' => $newSQL,
            'sort' => [
                'attributes' => [
                'title','created_at','state'
            ],
            'defaultOrder' => [
                'title' => SORT_ASC,   
                'created_at' => SORT_ASC,
            ]
            ],
        ]);

        $applications = new ApplicationSearch();        
        $savedProvider = $applications->search(['ApplicationSearch' =>['user_id' => Yii::$app->user->identity->id,'state' => 'Gespeichert']]);

       return $this->render('index', [
            'savedProvider' => $savedProvider,
            'sentProvider' => $sentProvider,
        ]);
    }

    public function actionAddData($id)
    {
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

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
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

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

    public function actionDropdownAction() {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/application");}

        $ids = Yii::$app->request->post('ids');
        $action = Yii::$app->request->post('action');

        for ($i=0; $i < count($ids); $i++) { 
            $tmpID = $ids[$i];
            $app = Application::findOne($tmpID);
            $job = Job::findOne($app->job_id);
            $user = Yii::$app->user->identity;
            $applier = User::findOne($app->user_id);

            $message = new Message();
            $message->subject = "Deine Bewerbung als: ".$job->title;
            $message->sender_id = $user->id;
            $message->receiver_id = $applier->id;
            
            if($action == "archive") {
            $app->delete();
            $message->content = "Leider hat sich das Unternehmen nicht für deine Bewerbung entschieden.";
            }
            else if($action == "invite") {
            $app->state = "Vorstellungsgespräch";
            $app->save();
            $message->content = "Herzlichen Glückwunsch, du wurdest zu einem Vorstellungsgespräch eingeladen. Kontaktiere nun den Rercuiter um weitere Informationen zu erhalten";  
            }
            else if($action == "hire") {
            $message->content = "Herzlichen Glückwunsch! Soeben wurdest du von ".$applier->fullName. " für den Job ". $job->title." eingestellt.";
            }
            if(($action != "read") && ($action != "unread")) {$message->save();}
            else {
                if($action == "read") {
                    $app->read = 1;
                    $app->save();
                }
                else if($action == "unread"){
                    $app->read = 0;
                    $app->save();
                }
            }
        }
        if($action == "read" || $action == "unread") {$this->redirect("/application?new=true");}
        else {$this->redirect("/application");}
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

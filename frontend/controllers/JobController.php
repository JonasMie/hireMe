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
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\JobCreateForm;
use frontend\models\ApplyBtnSearch;
use frontend\models\Favourites;
use frontend\models\CoverCreateForm;
use yii\data\SqlDataProvider;
use frontend\models\File;

/**
 * JobController implements the CRUD actions for Job model.
 */
class JobController extends Controller
{

    public $layout = 'main';

    public function behaviors()
    {
        return [
            'access'      => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ],
            ],
            'verbs'       => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
        ];
    }

    public function actionCreateBtn($id)
    {

        $model = new ApplyBtn();

        if ($model->load(Yii::$app->request->post())) {
            $model->clickCount = 0;
            $model->viewCount = 0;
            $model->job_id = $id;
            $model->key = $this->generateBtn($id);
            $model->save();
            return $this->redirect(['view', 'id' => $id]);
        } else {
            return $this->render('createBtn', [
                'model' => $model,
            ]);
        }

    }

    public function actionDelete($id)
    {
        $btn = ApplyBtn::findOne($id);
        $btn->delete();
        return $this->redirect(['index']);
    }

    /**
     * Lists all Job models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->user->identity->isRecruiter()) {
            $companyId = Yii::$app->user->identity->getCompanyId();
            Yii::trace("Company ID: " . $companyId);
            // For displaying applier data
            $analytics = new Analytics();
            $allJobs = $analytics->getJobs($companyId);

            $jobs = new JobSearch();
            $dataProvider = $jobs->search(['JobSearch' => ['company_id' => $companyId]]);

            return $this->render('index', [
                'indiTitle' => "Stellenanzeigen von " . Company::getNameById($companyId),
                'id'        => $companyId,
                'provider'  => $dataProvider,
            ]);

        } else {

            $jobs = new JobSearch();
            $dataProvider = $jobs->search(['JobSearch']);

            return $this->render('index', [
                'indiTitle' => "Nur für dich, " . Yii::$app->user->identity->getName() . " <3",
                'provider'  => $dataProvider,
            ]);

        }
    }

    public function actionGeneration($id)
    { //expecting job id
        Yii::trace("called");
        $key = $this->generateBtn($id);
        $text = "//Copy this code in your header(ask your freaky programmer for that!)\n<script src='http://frontend/js/applier.js'></script>\n//Copy this code wherever you want the HireMe Button\n<div id='ac' name='" . $key . "'></div>";
        return $this->renderAjax('keyView', ['key' => $key, 'text' => $text]);
    }

    /**
     * Displays a single Job model.
     *
     * @param integer $id
     *
     * @return mixed
     */

    public function actionView($id)
    {
        $query = ApplyBtn::find()
            ->where(['job_id' => $id])
            ->orderBy('id');

        $searchModel = new ApplyBtnSearch();
        $dataProvider = $searchModel->search(['ApplyBtnSearch' => ['job_id' => $id]]);

        return $this->render('view', [
            'model'        => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);

    }

    public function actionSaveFavorit($key, $user)
    {

        $fav = new Favourites();

        $thisBtn = ApplyBtn::find()
            ->where(['key' => $key])
            ->one();
        $job = Job::findOne($thisBtn->job_id);


        $favs = Favourites::find()->orderBy('id')->all();
        if (count($favs) == 0) {
            $fav->id = 0;
        } else {
            $highestID = $favs[count($favs) - 1];
            $fav->id = $highestID->id + 1;
        }
        $fav->job_id = $job->id;
        $fav->user_id = $user;
        $fav->save();
        return $this->renderPartial("savedFavourite");

    }

    public  function createAndEdit($key,$user) {

        $app = new Application();

        $apps = Application::find()->orderBy('id')->all();
        if (count($apps) == 0) {
            $app->id = 0;
        } else {
            $highestID = $apps[count($apps) - 1];
            $app->id = $highestID->id + 1;
        }


        $thisBtn = ApplyBtn::find()
            ->where(['key' => $key])
            ->one();

        $job = Job::find()->where(['id' => $thisBtn->job_id])->one();
        Yii::trace("Job ID: " . $job->id);
        $app->user_id = $user;
        $app->company_id = $job->company_id;
        $app->job_id = $job->id;
        $app->state = "Gespeichert";
        $app->btn_id = $thisBtn->id;
        $app->save();
        $user = Yii::$app->user->identity;

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

        $sentSQL = "SELECT f.title, ad.id from file f, application_data ad, application a WHERE a.user_id = ".$user->id." and ad.application_id = a.id and ad.file_id = f.id and a.id =".$app->id;
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


        if ($model->load(Yii::$app->request->post())) {

            if ($model->create() == true) {

            }


        }

        return $this->renderPartial('buttonAddData', [
            'model' => $model,
            'appId' => $app->id,
            'job' => $job,
            'provider' => $provider,
            'sentProvider' => $sentProvider
        ]);
    }

     public function actionSend($id) {

        $app = Application::findOne($id);
        $app->state = "Versendet";
        $app->sent = 1;
        $app->save();
        $this->redirect("/application");
    }

    public function addData() {

         if (Yii::$app->request->isAjax) {

        $id = File::findOne(Yii::$app->request->get('fileID')->id);
        $app = Application::findOne(Yii::$app->request->get('app'));
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

        $this->renderAjax("sentAppData");
        $this->renderAjax("possibleAppData");

        }

    }

    public function removeData($id,$appID) {

        $app = Application::findOne($appID);
        $appData = ApplicationData::findOne($id);
        $appData->delete();
        $this->renderAjax("sentAppData");
        $this->renderAjax("possibleAppData");

    }

    public function actionApply($key, $user)
    {

        $app = new Application();

        $apps = Application::find()->orderBy('id')->all();
        if (count($apps) == 0) {
            $app->id = 0;
        } else {
            $highestID = $apps[count($apps) - 1];
            $app->id = $highestID->id + 1;
        }


        $thisBtn = ApplyBtn::find()
            ->where(['key' => $key])
            ->one();


        $job = Job::find()->where(['id' => $thisBtn->job_id])->one();
        Yii::trace("Job ID: " . $job->id);
        $app->user_id = $user;
        $app->company_id = $job->company_id;
        $app->job_id = $job->id;
        $app->state = "Gespeichert";
        $app->btn_id = $thisBtn->id;
        $app->save();
        //return $this->render('applied');
        $this->redirect(["./application/add-data?id=" . $app->id]);

    }

    public function getAppIDByKeyAndUser($key,$user) {

         $app = new Application();

        $apps = Application::find()->orderBy('id')->all();
        if (count($apps) == 0) {
            $app->id = 0;
        } else {
            $highestID = $apps[count($apps) - 1];
            $app->id = $highestID->id + 1;
        }

        $thisBtn = ApplyBtn::find()
            ->where(['key' => $key])
            ->one();

        $job = Job::find()->where(['id' => $thisBtn->job_id])->one();
        Yii::trace("Job ID: " . $job->id);
        $app->user_id = $user;
        $app->company_id = $job->company_id;
        $app->job_id = $job->id;
        $app->state = "Gespeichert";
        $app->btn_id = $thisBtn->id;
        $app->save();

        return $app->id;

    }

    public function actionApplyIntern($id)
    { // expected job id

        $user = Yii::$app->user->identity;

        $app = new Application();

        $job = Job::findOne($id);

        $apps = Application::find()->orderBy('id')->all();
        if (count($apps) == 0) {
            $app->id = 0;
        } else {
            $highestID = $apps[count($apps) - 1];
            $app->id = $highestID->id + 1;
        }

        $app->user_id = $user->id;
        $app->company_id = $job->company_id;
        $app->job_id = $id;
        $app->state = "Gespeichert";
        $app->sent = 0;
        $app->read = 0;
        $app->archived = 0;
        $app->save();

        $this->redirect(["./application/add-data?id=" . $app->id]);

    }


    // count views
    public function actionViewUp($btnKey)
    {

        $btn = ApplyBtn::find()
            ->where(['key' => $btnKey])
            ->one();
        $btn->viewCount = $btn->viewCount + 1;
        $btn->save();
    }

    //count clicks
    public function actionClickUp($btnKey)
    {

        $btn = ApplyBtn::find()
            ->where(['key' => $btnKey])
            ->one();

        $btn->clickCount = $btn->clickCount + 1;
        $btn->save();

    }

    /**
     * Creates a new Job model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
        $model = new JobCreateForm();

        $jobId = 0;

        $jobs = Job::find()->orderBy('id')->all();
        if (count($jobs) == 0) {
            $jobId = 0;
        } else {

            $highestID = $jobs[count($jobs) - 1];
            $jobId = $highestID->id + 1;
        }

        if ($model->load(Yii::$app->request->post())) {

            if ($model->create() == true) {
                $session = Yii::$app->session;
                if ($session->has('savedKey')) {
                    $key = $session['savedKey'];
                    $btnId = $session['savedID'];
                    $site = $session['savedSite'];
                    $session->close();
                    $btn = new ApplyBtn();
                    $btn->id = $btnId;
                    $btn->job_id = $jobId;
                    $btn->key = $key;
                    $btn->site = $site;
                    $btn->viewCount = 0;
                    $btn->clickCount = 0;
                    $btn->save();
                }
                Yii::trace("called index");
                $this->redirect('index');
            } else {
                return $this->render('create', [
                    'model'        => $model,
                    'key'          => 'bla',
                    'assumedJobId' => $jobId,
                ]);
            }
        } else {
            return $this->render('create', [
                'model'        => $model,
                'key'          => "blöa",
                'assumedJobId' => $jobId,

            ]);
        }

    }

    private function keyGeneration($keyBase)
    {

        $key = md5(uniqid($keyBase, true));

        $btns = ApplyBtn::find()->orderBy('id')->all();
        for ($i = 0; $i < count($btns); $i++) {

            if ($key == $btns[$i]->key) {
                $this->$keyGeneration($keyBase);
            }

        }

        return $key;
    }

    public function generateBtn($id, $site = null)
    {

        $thisUser = Yii::$app->getUser();
        $getUser = User::findOne($thisUser->id);

        $btnId = 0;

        $btns = ApplyBtn::find()->orderBy('id')->all();
        if (count($btns) == 0) {
            $btnId = 0;
        } else {

            $highestID = $btns[count($btns) - 1];
            $btnId = $highestID->id + 1;
        }

        $keyBase = 'fuckingYII' . '_' . $btnId;
        $key = $this->keyGeneration($keyBase);

        $session = Yii::$app->session;
        $session->open();
        $session['savedKey'] = $key;
        $session['savedID'] = $btnId;
        $session['savedSite'] = $site;
        return $key;

    }

    public function getSomething()
    {

        return 10;
    }

    public function actionViewCount()
    {


        return $this->renderPartial('viewCountIFrame');
    }

    public function actionButtonPopup($key)
    {
        $hasApplied = 0;

        // $cookie = Yii::$app->request->cookies->getValue('usr_', 'NA');
        if (Yii::$app->user->isGuest) {
            $userID = "NA";
        } else {
            $this->layout = 'empty';
            $userID = Yii::$app->user->identity->id;
            $btn = ApplyBtn::find()
                ->where(['key' => $key])
                ->one();
            $job = Job::findOne($btn->job_id);

            $possibleApp = Application::find()
                ->where(['job_id' => $job->id, 'user_id' => $userID])
                ->all();
            if (count($possibleApp) == 1) {
                $hasApplied = 1;
            } else {
                $hasApplied = 0;
            }
        }

        return $this->render('buttonPopupWindow', [
            'userID'  => $userID,
            'applied' => $hasApplied,
        ]);

    }

    public function actionUpdate($id)
    {

        $model = ApplyBtn::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('updateBtn', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Job model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */

    public function actionUpdateJob($id)
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
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDeleteJob($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Job model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
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

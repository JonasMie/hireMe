<?php

namespace frontend\controllers;

use common\behaviours\BodyClassBehaviour;
use frontend\models\Geo;
use Yii;
use frontend\models\Job;
use frontend\models\Company;
use frontend\models\Analytics;
use frontend\models\Application;
use common\models\User;
use frontend\models\JobSearch;
use frontend\models\ApplyBtn;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
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
use frontend\models\ApplicationData;
use yii\helpers\Html;

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
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/job");}

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
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

         if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/job");}

        $btn = ApplyBtn::findOne($id);
        $btn->delete();
        return $this->redirect(['index']);
    }

    /**
     * Lists all Job models.
     * @return mixed
     */

    public function actionIndex($dist = null)
    {
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

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
            if (isset(Yii::$app->user->identity->geo_id)) {
                $jobs = $this->findJobRadius($dist)->all();
                $dataProvider = new ArrayDataProvider(['allModels' => $jobs]);
            } else {
                $jobs = Job::find();
                $dataProvider = new ActiveDataProvider(['query' => $jobs]);
            }

            return $this->render('index', [
                'provider' => $dataProvider,
            ]);

        }
    }

    public function actionGeneration($id)
    { //expecting job id
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/job");}
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
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

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

    public function actionSaveFavorit()
    {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/job");}
        if (Yii::$app->request->isAjax) {

            $fav = new Favourites();

            $thisBtn = ApplyBtn::find()
                ->where(['key' => Yii::$app->request->get('key')])
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
            $fav->user_id = Yii::$app->request->get("user");
            if ($fav->save()) {
                return "Die Stellenanzeige wurde deinen Favoriten hinzugefügt";
            }

        }

    }

    public function actionCreateApp()
    {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

        if (Yii::$app->request->isAjax) {

            $appData = Yii::$app->request->get("appData");

            if (Yii::$app->request->get("appID") == "false") {

            $app = new Application();
            $apps = Application::find()->orderBy('id')->all();
            if (count($apps) == 0) {
                    $app->id = 0;
            } else {
                    $highestID = $apps[count($apps) - 1];
                    $app->id = $highestID->id + 1;
                }
            } else {
                $app = Application::findOne(Yii::$app->request->get("appID"));
            }

            if(Yii::$app->request->get('intern') == 'true') {

                $job = Job::find()->where(['id' => Yii::$app->request->get('job')])->one();
                $app->user_id = Yii::$app->user->identity->id;
                $app->company_id = $job->company_id;
                $app->job_id = $job->id;
                $app->state = "Gespeichert";
                $app->save();
            }
            else {

            $key = Yii::$app->request->get("key");
            $user = Yii::$app->user->identity;
            $thisBtn = ApplyBtn::find()
                ->where(['key' => $key])
                ->one();
            $job = Job::find()->where(['id' => $thisBtn->job_id])->one();
            $app->user_id = $user->id;
            $app->company_id = $job->company_id;
            $app->job_id = $job->id;
            $app->state = "Gespeichert";
            $app->btn_id = $thisBtn->id;
            $app->save();

            }
    
            ApplicationData::deleteAll(['application_id' => $app->id]);

            for ($i = 0; $i < count($appData); $i++) {
                $tmpFile = $appData[$i];

                $data = new ApplicationData();
                $appDatas = ApplicationData::find()->orderBy('id')->all();
                if (count($appDatas) == 0) {
                    $data->id = 0;
                } else {
                    $highestID = $appDatas[count($appDatas) - 1];
                    $data->id = $highestID->id + 1;
                }
                $data->application_id = $app->id;
                $data->file_id = $tmpFile;
                $data->save();
            }

            $model = new CoverCreateForm();
            $model->app = $app->id;
            $text = Yii::$app->request->get('text');
            $model->text = $text;
            if ($model->create() == true) {
                return $app->id;
            } else {
                return "Leider gab es einen Fehler beim Speichern der Bewerbung.";
            }
        }

    }

    public function createFavoritSection($key,$user) {

        $thisBtn = ApplyBtn::find()
        ->where(['key' => $key])
        ->one();

        $job = Job::find()->where(['id' => $thisBtn->job_id])->one();
        Yii::trace("Job ID: " . $job->id);
        $user = Yii::$app->user->identity;

        if($user->isRecruiter()) {return $this->render('favoritError',['message' => "<p>Als Recruiter kannst du keine Favoriten erstellen. Das tut uns sehr leid.<br>Zur Entschädigung haben wir hier".Html::a("Zurück zu HireMe","/dashboard")." "]);}
        return $this->render('favoritSection');
    }

    public function createApplyForm($key, $user)
    {

        $thisBtn = ApplyBtn::find()
            ->where(['key' => $key])
            ->one();

        $job = Job::find()->where(['id' => $thisBtn->job_id])->one();
        Yii::trace("Job ID: " . $job->id);
        $user = Yii::$app->user->identity;

        $possibleApp = Application::find()
        ->where(['user_id' => $user->id, 'job_id' => $job->id])
        ->one();

        if($user->isRecruiter()) {return $this->render('applyError',['message' => "<p>Als Recruiter kannst du dich nicht auf eine Stelle bewerben.<br><br>Logge dich für eine Bewerbung als Bewerber ein.<br><br>".Html::a("Zurück zu HireMe","/dashboard")." "]);}
        if(count($possibleApp) == 1) {return $this->render('applyError',['message' => "Du hast dich bereits auf diese Stelle beworben.<br>".Html::a("Bewerbungen ansehen","/application")." "]);}
        $newSQL = "SELECT f.title, f.id FROM file f WHERE NOT (f.title LIKE '%cover%') AND f.user_id = " . $user->id;
        Yii::trace("User ID: " . $user->id);

        $provider = new SqlDataProvider([
            'sql'  => $newSQL,
            'sort' => [
                'attributes'   => [
                    'title'
                ],
                'defaultOrder' => [
                    'title' => SORT_ASC,
                ]
            ],
        ]);

        return $this->render('addData', [
            'job'      => $job,
            'provider' => $provider,
            'controller' => 'extern',
        ]);
    }

    public function actionSend()
    {
        if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

        if (Yii::$app->request->isAjax) {

            $app = Application::findOne(Yii::$app->request->get("appID"));
            $app->state = "Versendet";
            $app->sent = 1;
            if ($app->save()) {

                return "Vielen Dank, deine Bewerbung wurde versandt :)";
            }

        }

    }

    public function actionApply($key, $user)
    {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}
    if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

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
        $this->redirect(["./application/add-data?id=" . $app->id]);

    }

    public function getAppIDByKeyAndUser($key, $user)
    {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/application");}

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
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter()) {$this->redirect("/application");}

        $user = Yii::$app->user->identity;

        $app = new Application();

        $job = Job::findOne($id);

         $newSQL = "SELECT f.title, f.id FROM file f WHERE NOT (f.title LIKE '%cover%') AND f.user_id = " . $user->id;
        Yii::trace("User ID: " . $user->id);

        $provider = new SqlDataProvider([
            'sql'  => $newSQL,
            'sort' => [
                'attributes'   => [
                    'title'
                ],
                'defaultOrder' => [
                    'title' => SORT_ASC,
                ]
            ],
        ]);
        return $this->render('addData', [
            'job'      => $job,
            'provider' => $provider,
            'controller' => "intern",
        ]);
        


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
      
      if(Yii::$app->user->identity->isRecruiter() == false) {
         $btn = ApplyBtn::find()
            ->where(['key' => $btnKey])
            ->one();
        $btn->clickCount = $btn->clickCount + 1;
        $btn->save();
        }
    }

    /**
     * Creates a new Job model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate()
    {
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter()==false) {$this->redirect("/application");}

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

    public function actionViewCount() {return $this->renderPartial('viewCountIFrame');}

    public function actionButtonPopup($key)
    {
        if (Yii::$app->user->isGuest) {
            $userID = "NA";
        } else {
            $this->layout = 'empty';
            $userID = Yii::$app->user->identity->id;
        }
        return $this->render('buttonPopupWindow', [
            'userID'  => $userID,
            'key'     => $key,
        ]);

    }

    
/*
    public function actionUpdate($id)
    {
    if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/job");}

        $model = ApplyBtn::findOne($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('updateBtn', [
                'model' => $model,
            ]);
        }

    }
*/
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
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

    if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/job");}

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
    if (Yii::$app->user->isGuest) {$this->redirect("/site/login");}

        if(Yii::$app->user->identity->isRecruiter() == false) {$this->redirect("/job");}
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

    public function findJobRadius($dist)
    {
        $earthRadius = 6371;
        $geo = Geo::findOne(['id' => Yii::$app->user->identity->geo_id]);

        $lat = $geo->lat;
        $lon = $geo->lon;


        if (isset($dist)) {
            // first-cut bounding box (in degrees)
            $maxLat = $lat + rad2deg($dist / $earthRadius);
            $minLat = $lat - rad2deg($dist / $earthRadius);

            // compensate for degrees longitude getting smaller with increasing latitude
            $maxLon = $lon + rad2deg($dist / $earthRadius / cos(deg2rad($lat)));
            $minLon = $lon - rad2deg($dist / $earthRadius / cos(deg2rad($lat)));
        }

        $lat = deg2rad($lat);
        $lon = deg2rad($lon);


        if (isset($dist)) {
            $distQuery = (new Query())
                ->select(['plz', 'city', "distance" => "acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon)) * $earthRadius"])
                ->from(['firstCut' => (new Query())
                    ->select(['id', 'plz', 'city', 'lat', 'lon'])
                    ->from('geo')
                    ->where(['and', ['between', 'lat', $minLat, $maxLat], ['between', 'lon', $minLon, $maxLon]])])
                ->where("acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon)) * $earthRadius < $dist");
        } else {
            $distQuery = (new Query())
                ->select(['plz', 'city', "distance" => "acos(sin($lat)*sin(radians(lat)) + cos($lat)*cos(radians(lat))*cos(radians(lon)-$lon)) * $earthRadius"])
                ->from('geo');
        }

        return (new Query())
            ->from('job')
            ->leftJoin(
                [
                    "dist" => $distQuery
                ]
                , 'dist.plz = job.zip')
            ->select(['job.*', 'dist.distance', 'dist.city'])
            ->orderBy('distance');

    }
}

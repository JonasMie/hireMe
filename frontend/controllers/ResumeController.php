<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 07.06.15
 * Time: 23:26
 * Project: hireMe
 */

namespace frontend\controllers;


use common\behaviours\BodyClassBehaviour;
use frontend\helper\Setup;
use frontend\models\Company;
use frontend\models\File;
use frontend\models\MessageAttachments;
use frontend\models\ResumeJob;
use frontend\models\ResumeJobSearch;
use frontend\models\ResumeSchool;
use frontend\models\ResumeSchoolSearch;
use Yii;
use yii\base\InvalidCallException;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

class ResumeController extends Controller
{

    public function behaviors()
    {
        return [
            'access'      => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'delete', 'update'],
                        'allow'   => true,  // TODO: set allow to false
                        'roles'   => ['@'], // TODO: set roles to '?'
                    ],
                ],
            ],
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
        ];
    }

    /**
     * Lists all ResumeJob models.
     * @return mixed
     */
    public function actionIndex()
    {
        if (Yii::$app->request->post()) {
            $model = null;
            $resumeType = null;
            $post = Yii::$app->request->post();
            if (isset($post['ResumeJob'])) {
                $resumeType = 1;
                $model = ResumeJob::findOne($post['ResumeJob']['id']);
                if (isset($post['ResumeJob']['company_id'])) {
                    $company = Company::findByName($post['ResumeJob']['company_id']);
                }
            } else if (isset($post['ResumeSchool'])) {
                $resumeType = 2;
                $model = ResumeSchool::findOne($post['ResumeSchool']['id']);
            }

            if ($model->load($post)) {
                if ($resumeType == 1) {
                    if ($company == null) {
                        $newCompany = new Company();
                        $newCompany->name = $model->company_id;
                        $newCompany->save();
                        $model->company_id = $newCompany->id;
                    } else {
                        $model->company_id = $company->id;
                    }
                }
                $report_id = $this->upload($model);
                if ($report_id) {
                    $model->report_id = $report_id;
                } else if($report_id==false && $report_id!==null) {
                    $jobDataProvider = new ActiveDataProvider(['query' => ResumeJob::find(['user_id' => Yii::$app->user->getId()]),]);

                    $schoolDataProvider = new ActiveDataProvider(['query' => ResumeSchool::find(['user_id' => Yii::$app->user->getId()]),]);

                    return $this->render('index', ['jobDataProvider'    => $jobDataProvider,
                                                   'schoolDataProvider' => $schoolDataProvider]);
                }
                if ($model->save()) {

                    $jobDataProvider = new ActiveDataProvider([
                        'query' => ResumeJob::find(['user_id' => Yii::$app->user->getId()]),
                    ]);

                    $schoolDataProvider = new ActiveDataProvider([
                        'query' => ResumeSchool::find(['user_id' => Yii::$app->user->getId()]),
                    ]);

                    return $this->render('index', [
                        'jobDataProvider'    => $jobDataProvider,
                        'schoolDataProvider' => $schoolDataProvider
                    ]);
                }
            }
        } else {
            $jobDataProvider = new ActiveDataProvider(['query' => ResumeJob::find()->where(['user_id' => Yii::$app->user->getId()])]);

            $schoolDataProvider = new ActiveDataProvider(['query' => ResumeSchool::find()->where(['user_id' => Yii::$app->user->getId()])]);

            return $this->render('index', ['jobDataProvider'    => $jobDataProvider,
                                           'schoolDataProvider' => $schoolDataProvider]);
        }
    }

    public
    function actionCreate($type)
    {
        $model = null;
        if ($type == "job") {
            $model = new ResumeJob();
        } else if ($type == "school") {
            $model = new ResumeSchool();
        } else {
            return $this->redirect(['/resume']);
        }

        $model->user_id = Yii::$app->user->getId();
        if ($model->load(Yii::$app->request->post())) {
            if (isset($model->company_id)) {
                $company = Company::findByName($model->company_id);
                if ($company == null) {
                    $newCompany = new Company();
                    $newCompany->name = $model->company_id;
                    $newCompany->save();
                    $model->company_id = $newCompany->id;
                } else {
                    $model->company_id = $company->id;
                }
            }
            $report_id = $this->upload($model);
            if ($report_id) {
                $model->report_id = $report_id;
            }
            if ($model->save()) {
                return $this->redirect(['/resume']);
            } else {
                return $this->render($type . 'ResumeCreate', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render($type . 'ResumeCreate', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ResumeJob|ResumeSchool model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public
    function actionUpdate()
    {

//
//        if ($model->load($post) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    public
    function actionDelete()
    {
        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax && isset($post['type'])) {
            $id = $post['id'];
            $type = $post['type'];
            if ($type == 'job') {
                $model = ResumeJob::findOne($id);
            } else if ($type == 'school') {
                $model = ResumeSchool::findOne($id);
            }
            if ($model->delete()) {
                echo Json::encode([
                    'success'  => true,
                    'messages' => [
                        'kv-detail-success' => 'Der Eintrag wurde erfolgreich gelöscht.'
                    ]
                ]);
            } else {
                echo Json::encode([
                    'success'  => false,
                    'messages' => [
                        'kv-detail-error' => 'Das Löschen des Eintrags ist leider fehlgeschlagen.'
                    ]
                ]);
            }
            return;
        }
        throw new InvalidCallException("You are not allowed to do this operation. Contact the administrator.");
    }

    private function upload($model)
    {
        $report = new File();
        $model->report_id = UploadedFile::getInstance($model, 'report_id');
        if ($model->report_id && $model->validate()) {
            $report->path = "/" . uniqid("report_");
            $report->extension = $model->report_id->extension;
            $report->size = $model->report_id->size;
            $report->title = $model->report_id->baseName;
            if ($report->save() && $model->report_id->saveAs(Yii::getAlias('@webroot') . '/uploads/reports/' . $report->path . '.' . $report->extension)) {
                return $report->id;
            }
            return false;
        }
    }
}
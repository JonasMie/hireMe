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
use frontend\models\ResumeJob;
use frontend\models\ResumeJobSearch;
use frontend\models\ResumeSchool;
use frontend\models\ResumeSchoolSearch;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;

class ResumeController extends Controller
{

    public function behaviors()
    {
        return [
            'access'      => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'create'],
                        'allow'   => true,  // TODO: set allow to false
                        'roles'   => ['@'], // TODO: set roles to '?'
                    ],
//                    [
//                        'actions' => ['settings'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
                ]
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
        $jobDataProvider = new ActiveDataProvider([
            'query'=> ResumeJob::find(['user_id' => Yii::$app->user->getId()]),
        ]);

        $schoolDataProvider = new ActiveDataProvider([
            'query'=> ResumeSchool::find(['user_id' => Yii::$app->user->getId()]),
        ]);

        return $this->render('index', [
            'jobDataProvider' => $jobDataProvider,
            'schoolDataProvider' => $schoolDataProvider
        ]);
    }

    public function actionCreate($type)
    {
        if($type=="work"){
            $this->render('jobResumeCreate');
        } else if($type=="school"){

        }
    }
}
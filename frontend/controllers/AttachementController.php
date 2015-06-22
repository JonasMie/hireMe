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

class AttachementController extends Controller
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

    public function actionShowFile($id) {

        $file = File::find()
        ->where(["id" => $id])->one();
        Yii::trace("file title: ".$file->title);
        $user_id = $file->user_id;
        $this->redirect("/uploads".$file->path.'.'.$file->extension);
        
    }

    public function actionIndex()
    {
    	$user = Yii::$app->user->identity;
  		$sql = "SELECT title,id from file WHERE NOT (title LIKE '%cover%') AND user_id =".$user->id;
  		$model = new UploadForm();

  		$fileDataProvider = new SqlDataProvider([
            'sql' => $sql,
            'sort' => [
                'attributes' => [
                'title',
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
                $file->path = "/appData/AD_".md5($user->id.'_'.$file->id);
                $file->extension = $model->file->extension;
                $file->size = $model->file->size;
                $file->title = $model->title;
                $file->user_id = $user->id;
                if($file->save()) {
                $model->file->saveAs("uploads".$file->path.'.' . $model->file->extension);                
                Yii::trace("Saved file");
                }
                $this->renderPartial("uploadSection", ['model'=>$model,'provider' => $fileDataProvider]);
            }
        }

        return $this->render('index', ['model'=>$model,'provider' => $fileDataProvider]);


    }

}

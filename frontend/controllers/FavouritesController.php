<?php

namespace frontend\controllers;

use common\behaviours\BodyClassBehaviour;
use Yii;
use frontend\models\Favourites;
use frontend\models\FavouritesSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * FavouritesController implements the CRUD actions for Favourites model.
 */
class FavouritesController extends Controller
{
    public function behaviors()
    {
        return [
            'access'      => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow'   => true,
                        'roles'   => ['@']
                    ]
                ],
            ],
            'verbs'       => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'toggle' => ['post'],
                ],
            ],
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
        ];
    }

    /**
     * Lists all Favourites models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FavouritesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Favourites model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $keys = Yii::$app->request->post('keys');
        if (!is_null($id) && !is_array($id)) {
            $this->findModel($id)->delete();
        } else if (!is_null($keys) && is_array($keys)) {
            Favourites::deleteAll(['and', ['in','id',$keys], 'user_id = ' . Yii::$app->user->getId()]);
        }
        return $this->redirect('/favourites');
    }

    /**
     * Finds the Favourites model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Favourites the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Favourites::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionToggle()
    {
        if(Yii::$app->request->isAjax){
            $job_id = Yii::$app->request->post('id');
            \Yii::$app->response->format = Response::FORMAT_JSON;
            if(isset($job_id)){
                $model = Favourites::findAll(['user_id' => Yii::$app->user->getId(), 'job_id' => $job_id]);
                if(empty($model)){
                    $fav = new Favourites();
                    $fav->user_id = Yii::$app->user->getId();
                    $fav->job_id = $job_id;
                    if(!$fav->save()){
                        return [
                            'success' => false,
                        ];
                    }
                    $type = "remove";
                } else {
                    foreach($model as $fav){
                        $fav->delete();
                    }
                    $type = "add";
                }
                return [
                    'success' => true,
                    'type' => $type,
                ];
            }
        }
    }
}

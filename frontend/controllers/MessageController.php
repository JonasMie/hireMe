<?php

namespace frontend\controllers;

use common\behaviours\BodyClassBehaviour;
use common\models\User;
use frontend\models\Message;
use frontend\models\MessageAttachments;
use frontend\models\MessageCreate;
use Yii;
use frontend\models\MessageSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
{
    public function behaviors()
    {
        return [
            'access'      => [
                'class' => AccessControl::className(),
                'only'  => ['view', 'index'],
                'rules' => [
                    [
                        'actions'       => ['view'],
                        'allow'         => true,
                        'matchCallback' => function () {
                            $messageModel = new Message();
                            return $messageModel->belongsToUser(Yii::$app->user->identity->getId(), Yii::$app->request->get()['id']);
                        }
                    ],
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
                ],
            ],
            'bodyClasses' => [
                'class' => BodyClassBehaviour::className()
            ]
        ];
    }

    /**
     * Lists all Message models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MessageSearch();
//        $dataProvider = $searchModel->search(['MessageSearch' =>['receiver_id' => Yii::$app->user->identity->getId(), 'sender_id' =>Yii::$app->user->identity->getId()]],true);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Message model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $attachments = MessageAttachments::find()->where(['message_id' => $id])->all();
        $reply = new MessageCreate();
        $reply->receiver = $model->receiver->fullName;
        return $this->render('view', [
            'model'       => $model,
            'attachments' => $attachments,
            'reply'       => $reply,
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($rec = null)
    {
        $model = new MessageCreate();
        $recModel = Yii::$app->request->post('MessageCreate');
        if (isset($recModel) && isset($recModel['receiver_id'])) {
            $rec = $recModel['receiver_id'];
        }
        if (isset($rec)) {
            $r = User::findIdentity($rec);
            $model->receiver = $r->fullName;
        }
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['./message']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Message model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
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
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->deleted = 1;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Message model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return Message the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

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
use yii\web\Response;

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
                'only'  => ['view', 'index','create'],
                'rules' => [
                    [
                        'actions'       => ['view'],
                        'allow'         => true,
                        'matchCallback' => function () {
                            $messageModel = new Message();
                            return !Yii::$app->user->isGuest && $messageModel->belongsToUser(Yii::$app->user->identity->getId(), Yii::$app->request->get()['id']);
                        }
                    ],
                    [
                        'actions' => ['index','create'],
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
        $attachments = MessageAttachments::findAll(['message_id' => $id]);
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
     * Marks one or multiple messages as read/unread
     *
     *
     * @return mixed
     */
    public function actionRead()
    {
        \Yii::$app->response->format = Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            $params = Yii::$app->request->get('keys');
            if (!is_null($params)) {
                $keys = array_values($params);
                $type = Yii::$app->request->get('type');
                Message::updateAll(['read' => $type == "read" ? 1 : 0], ['and', ['in', 'id', $keys], 'receiver_id = ' . Yii::$app->user->getId()]);
                return [
                    'success' => true,
                ];
            }
        }
        return [
            'success' => false,
        ];
    }

    /**
     * Deletes an existing Message model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @return mixed
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->get('id');
        $keys = Yii::$app->request->post('keys');
        if (!is_null($id) && !is_array($id)) {
            $model = $this->findModel($id);
            if ($model->sender_id == Yii::$app->user->getId()) {
                $model->deleted_sender = 1;
            } else if ($model->receiver_id == Yii::$app->user->getId()) {
                $model->deleted_receiver = 1;
            }
            $model->save();

        } else if (!is_null($keys) && is_array($keys)) {
            $messages = Message::find()->where(['and', ['in', 'id', $keys], ['or', 'receiver_id = ' . Yii::$app->user->getId(), 'sender_id = ' . Yii::$app->user->getId()]])->all();
            foreach ($messages as $message) {
                if ($message->receiver_id == Yii::$app->user->getId()) {
                    $message->deleted_receiver = 1;
                    $message->save();
                } else if ($message->sender_id == Yii::$app->user->getId()) {
                    $message->deleted_sender = 1;
                    $message->save();
                }
            }
        }
        return $this->goBack();
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

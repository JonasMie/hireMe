<?php

namespace frontend\Controllers;

use common\behaviours\BodyClassBehaviour;
use common\models\User;
use frontend\models\Message;
use frontend\models\MessageAttachments;
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
        $reply = new Message();
        $attachment = new MessageAttachments();
        return $this->render('view', [
            'model'      => $model,
            'reply'      => $reply,
            'attachment' => $attachment
        ]);
    }

    /**
     * Creates a new Message model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($rec = null)
    {
        // TODO: check if reply
        $model = new Message();
        $attachment = new MessageAttachments(); // TODO: set message id

        $model->sender_id = Yii::$app->user->identity->getId();
        $receiver = User::findIdentity($rec);
        if (isset($rec)) {
            $model->receiver_id = $receiver->id;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $attachment->uploadedFile = UploadedFile::getInstance($attachment, 'file');
            if ($attachment->uploadedFile && $attachment->validate()) {
                $filename = "/" . uniqid("ma_");
                $extension = $attachment->uploadedFile->extension;
                $size = $attachment->uploadedFile->size;
                $title = $attachment->uploadedFile->baseName;
                $attachment->message_id = $model->primaryKey;
                if (!$attachment->addFile($filename, $extension, $size, $title) || !$attachment->uploadedFile->saveAs(Yii::getAlias('@webroot') . '/uploads/messattachments/' . $filename . '.' . $attachment->uploadedFile->extension)) {

                    return $this->render('create', [
                        'model'      => $model,
                        'rec'        => $receiver,      // TODO: remove receiver, use $model->receiver_id instead
                        'attachment' => $attachment
                    ]);
                }
            }
            return $this->redirect(['./message']);
        } else {
            return $this->render('create', [
                'model'      => $model,
                'rec'        => $receiver,
                'attachment' => $attachment
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

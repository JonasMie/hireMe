<?php

use yii\helpers\Html;
use yii\grid\GridView;
use frontend\models\Application;
use frontend\controllers\ApplicationController;
use frontend\controllers\UserController;
use frontend\models\Job;
use yii\widgets\ListView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\ApplicationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="application-index">

     <? if (Yii::$app->user->identity->isRecruiter()): ?>
       
         <h1><?= Html::encode($title) ?></h1>

  <?= GridView::widget([
        'dataProvider' => $provider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'columns'      => [
        [
                'attribute' => 'fullName',
                'label' => 'Name',
                'format' => 'raw',
                'value'  => function ($data) {
                    return User::findOne($data["userID"])->getProfilePicture(true)."".Html::a($data['fullName'],'/user?un='.$data['userName']);
                }
        ], 
         'title:text:Stelle',
         [
                'attribute' => 'created_at',
                'label' => 'Beworben am',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::encode($data['created_at']);
                }
        ], 
        [
                'label'  => '',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a("Ansehen",'/application/view?id='.$data['id']);
                }
        ],    
        ],

    ]); ?>  


      <? else:?>

     <h2><?= Html::encode("Gespeicherte Bewerbungen:") ?></h2>

     <?= GridView::widget([
        'dataProvider' => $savedProvider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'columns'      => [
         [
                'label'  => 'Stellenanzeige',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Job::getTitle($data->job_id);
                }
            ],

        [
                'label'  => 'Erstellt',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::encode($data->created_at);
                }
        ],    
        [
                'label'  => 'Action',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a("Absenden",'/application/send?id='.$data->id)." - ".Html::a("Bearbeiten","/application/add-data?id=".$data->id);
                }
        ],    
        ],

    ]); ?>  
     <h2><?= Html::encode("Gesendete Bewerbungen:") ?></h2>

    <?= GridView::widget([
        'dataProvider' => $sentProvider,
        'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
        'columns'      => [
         [
                'label'  => 'Stellenanzeige',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Job::getTitle($data->job_id);
                }
            ],

        [
                'label'  => 'Erstellt',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::encode($data->created_at);
                }
        ],    
          [
                'label'  => 'Status',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::encode($data->state);
                }
        ],    
        [
                'label'  => '',
                'format' => 'raw',
                'value'  => function ($data) {
                    return Html::a("Ansehen",'/application/view?id='.$data->id);
                }
        ],    
        ],

    ]); ?>  
    
    <?= Html::a(Html::button("Neue Bewerbung"),'/job/') ?>

      <? endif; ?>

</div>

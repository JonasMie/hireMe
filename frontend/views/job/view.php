<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use frontend\models\Company;
use frontend\models\Job;
use frontend\models\Application;
use frontend\controllers\JobController;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Job */

?>
    <div class="job-view">

        <h1><?= Html::encode($this->title) ?></h1>

        <p>
            <? if (Yii::$app->user->identity->isRecruiter()): ?>

                <?= Html::a(Yii::t('app', 'Update'), ['update-job', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete-job', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data'  => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method'  => 'post',
                    ],
                ]) ?>

            <? endif; ?>

        </p>

        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'title',
                'description',
                'job_begin',
                'job_end',
                'zip',
                'sector',
                [                      // the owner name of the model
                    'label' => 'Company',
                    'value' => Company::getNameById($model->company_id),
                ],
                'active',
                'created_at',
                'city',
                'time:datetime',
            ],
        ]) ?>

        <? if (Yii::$app->user->identity->isRecruiter()): ?>
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'tableOptions' => ['class' => 'hireMeTable footable toggle-arrow', 'id' => 'inboxTable'],
                'columns'      => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'key:ntext',
                    'site:ntext',
                    [
                        'class'    => 'yii\grid\ActionColumn',
                        'template' => '{update}{delete}',
                    ],
                ],
                'caption'      => Html::a("Neuen Key generieren", '/job/create-btn?id=' . $model->id),
            ]); ?>
        <? else: ?>
            <?
            if (Application::existsApplicationFromUser(Yii::$app->user->identity->id, $model->id) == true) {
                echo Html::decode("Bewerbung ist bereits raus.<br>Status: " . Application::getApplicationStatByUserAndJob(Yii::$app->user->identity->id, $model->id));
            } else {
                echo Html::a(Html::button("Jetzt bewerben"), "/job/apply-intern?id=" . $model->id);
            }
        endif;


        $inFavourites = \frontend\models\Favourites::find()->where(['job_id' => $model->id, 'user_id' => Yii::$app->user->getId()])->count()> 0;
        if ($inFavourites) {
            $label = "Aus Favoriten entfernen";
            $class = "remove";
        } else {
            $label = "Zu Favoriten hinzufügen";
            $class = "add";
        }
        echo Html::a($label, '#', ['data-job' => $model->id, 'class' => $class, 'id' => 'toggleFavourite']);
        ?>
    </div>



<? // TODO: message if error
$this->registerJs("jQuery('#toggleFavourite').click(function (e) {e.preventDefault(); \$this = jQuery(this);jQuery.post('/favourites/toggle', {id: \$this.data('job')}, function (res) {if (res.success) {\$this.removeClass('add remove').addClass(res.type);if (res.type == 'add') {\$this.text('Zu Favoriten hinzufügen');} else {\$this.text('Aus Favoriten entfernen');}} else {return;}});});");
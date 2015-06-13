<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Message */
/* @var $form yii\widgets\ActiveForm */
/* @var $attachment frontend\models\MessageAttachments */
/* @var $receiver null|common\models\User */
?>

<div class="message-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <div class="row message-create-first-row">
        <div class="col-lg-6">

            <?= $form->field($model, 'subject')->textInput(['maxlength' => 255]) ?>


        </div>
        <div class="col-lg-6">


            <? echo "<label class='control-label typeahead-label'>Empfänger</label>"; ?>
            <?=
            // TODO: set receiver if $rec!== null
            Typeahead::widget([
                'name'         => 'receiver_name',
                'dataset'      => [
                    [
                        'remote' => Url::to(['site/user-search' . '?q=%QUERY']),
                        'limit'  => 10,
                    ],
                ],
                'pluginEvents' => [     // Typeahead search with bloodhound suggestion
                    "typeahead:selected" => 'function(x,y) {$("#message-receiver_id").val(y.id)}',
                ]

            ]) ?>

        </div>


    </div>





    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>



    <!--?= $form->field($model, 'receiver_id')->widget(Typeahead::className(), [
        'dataset' => [
            [
                'remote' => Url::to(['site/user-search'.'?q=%QUERY']),
                'limit' => 10,
            ],
        ],
        'pluginEvents' => [
            "typeahead:selected" => 'function(x,y) {$("#message-receiver_id").val(y.id)}',
        ]

    ])->label('Empfänger')->textInput()  ?-->

    <?= Html::activeHiddenInput($model, 'receiver_id') // TODO: check if exists    ?>

    <?= $form->field($attachment, 'file')->fileInput()->label('Anhang hinzufügen'); ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Nachricht versenden'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    <?php ActiveForm::end(); ?>

</div>

<script>
    // TODO: verschönern
    <? if (isset($receiver)){ ?>
        document.getElementById('w1').value = "<?=$receiver->fullName?>";
    <? } ?>
</script>
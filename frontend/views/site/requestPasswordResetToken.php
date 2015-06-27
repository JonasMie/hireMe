<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\PasswordResetRequestForm */
$this->title = "Passwort zurücksetzen";
?>
<div class="site-request-password-reset">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-5">
			<p>Bitte trage deine Email-Adresse ein. Wir schicken dir einen Code zu, über den du dein Passwort zurücksetzen kannst.</p>
            <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>
                <?= $form->field($model, 'email') ?>
                <div class="form-group">
                    <?= Html::submitButton('Passwort zurücksetzen', ['class' => 'btn btn-success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

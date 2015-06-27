<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = 'Neues Passwort festlegen';
?>

<div class="site-reset-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-5">
			<p>Bitte wähle dein neues Passwort.</p>
            <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <div class="form-group">
                    <?= Html::submitButton('Passwort speichern', ['class' => 'btn btn-primary success']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

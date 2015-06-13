<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 25.05.15
 * Time: 12:04
 * Project: hireMe
 */

use frontend\assets\ImageAssetBundle;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
<<<<<<< HEAD
$this->title = 'Eintstellungen';
ImageAssetBundle::register($this);
=======
$this->title = 'Einstellungen';
$this->params['breadcrumbs'][] = ['label' => 'Profil', 'url' => ['/user']];
$this->params['breadcrumbs'][] = $this->title;
>>>>>>> feature/userProfile
?>
<div class="user-settings">
    <? if(isset($success)){
        if($success){
            echo '<div><span class="alert-success">Deine Daten wurden aktualisiert.</span></div>';
        } else {
            echo '<div><span class="alert-danger">Beim Speichern ist leider ein Fehler aufgetreten.</span></div>';
        }
    }
    ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="settings-form">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?= $form->field($model, 'visibility')->radioList([0=>'Keiner kann das Profil sehen', 1=>'Recruiter können das Profil sehen', 2=>'Jeder kann das Profil sehen'])->label('Sichtbarkeit des Profils') ?>

        <div class="password-inputs">
            <fieldset>
                <legend>Passwort ändern</legend>
                <?= $form->field($model, 'oldPassword', ['inputOptions'=>['placeholder'=>'Altes Passwort']])->passwordInput()->label(false) ?>
                <?= $form->field($model, 'password', ['inputOptions'=>['placeholder'=>'Neues Passwort']])->passwordInput()->label(false) ?>
                <?= $form->field($model, 'password_repeat', ['inputOptions'=>['placeholder'=>'Neus Passwort wiederholen']])->passwordInput()->label(false) ?>
            </fieldset>
        </div>

        <?= $form->field($model, 'email')->textInput()->label('Neue Email-Adresse') ?>
        <?= $form->field($model, 'picture')->fileInput(); ?>

        <div style="width: 1000px; max-height: 1000px; overflow: scroll">
            <img id="settingsmodel-picture-jcrop" src="" style="display: none">
            <input type="text" id="w" name="w" style="display: none"  />
            <input type="text" id="h" name="h" style="display: none"  />
            <input type="text" id="x" name="x" style="display: none"  />
            <input type="text" id="y" name="y" style="display: none"  />
        </div>
        <div class="form-group">
            <?= Html::submitButton('Speichern', ['class' => 'btn btn-primary', 'name' => 'settings-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

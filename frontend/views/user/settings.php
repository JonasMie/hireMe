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


$this->title = 'Einstellungen';
ImageAssetBundle::register($this);


?>
<div class="user-settings">
    <? if(isset($success)){
        if($success){
            echo '<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  Deine Daten wurden aktualisiert.
				</div>';
        } else {
            echo '<div class="alert alert-success alert-dismissible" role="alert">
				  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				  Beim Speichern ist leider ein Fehler aufgetreten.
				</div>';
        }
    }
    ?>
	<div class="row">
		<div class="col-sm-10 col-sm-offset-1">
			<h1><?= Html::encode($this->title) ?></h1>
		</div>
	</div>
	
	<div class="row">
		<div class="settings-form">

			<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
			
			<div class="col-sm-4 col-sm-offset-1">
			<h2>Profilbild</h2>
			<?= $form->field($model, 'picture')->fileInput(); ?>

			<div>
				<img id="settingsmodel-picture-jcrop" src="" style="display: none">
				<input type="text" id="w" name="w" style="display: none"  />
				<input type="text" id="h" name="h" style="display: none"  />
				<input type="text" id="x" name="x" style="display: none"  />
				<input type="text" id="y" name="y" style="display: none"  />
			</div>
			
			</div>
			
			<div class="col-sm-4">
			
			<h2>Allgemein</h2>
			
			<?= $form->field($model, 'visibility')->radioList([0=>'Keiner kann das Profil sehen', 1=>'Recruiter können das Profil sehen', 2=>'Jeder kann das Profil sehen'])->label('Sichtbarkeit des Profils') ?>

			<div class="password-inputs">
				<fieldset>
					<legend>Passwort ändern</legend>
					<?= $form->field($model, 'oldPassword')->passwordInput()->label('Altes Passwort') ?>
					<?= $form->field($model, 'password')->passwordInput()->label('Neues Passwort') ?>
					<?= $form->field($model, 'password_repeat')->passwordInput()->label('Neues Passwort wiederholen') ?>
				</fieldset>
			</div>

			<?= $form->field($model, 'email')->textInput()->label('Neue Email-Adresse') ?>
			
			<div class="form-group">
				<?= Html::submitButton('Speichern', ['class' => 'btn btn-success ripple', 'name' => 'settings-button']) ?>
			</div>
			
			</div>

			<?php ActiveForm::end(); ?>

		</div>
	</div>

</div>

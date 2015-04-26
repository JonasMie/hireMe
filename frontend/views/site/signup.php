<?php
use frontend\assets\SignupAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;


/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

include Yii::getAlias('@helper/companySignup.php');


SignupAsset::register($this);
$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
                <?= $form->field($model, 'firstName')->label('Vorname')?>
                <?= $form->field($model, 'lastName')->label('Nachname') ?>
                <?= $form->field($model, 'email') ?>
                <?= $form->field($model, 'password')->passwordInput() ?>

                <br>
                <?= $form->field($model, 'checkCompanySignup')->checkbox(array('id'=>'checkCompanySignup'))->label('Als Recruiter registrieren') ?>


                <!-- Additional Information for recruiter signups -->


                <div class="companySetup" style="display: none">    <? //STYLE: display in css?>
                    <?= $form->field($model, 'companyName')->label('Name des Unternehmens')?>
                    <?= $form->field($model, 'companyAddress')->label('Anschrift des Unternehmens') ?>
                    <div class="row">
                        <div class="col-lg-9">
                            <?= $form->field($model, 'companyAddressStreet', array('inputOptions'=>['placeholder'=>'Straße']))->label(false) ?>
                        </div>
                        <div class="col-lg-3">
                            <?= $form->field($model, 'companyAddressNumber', array('inputOptions'=>['placeholder'=>'Nr.']))->label(false)?>
                        </div>
                    </div>
                    <?= $form->field($model, 'companyAddressZIP', array('inputOptions'=>['placeholder'=>'PLZ']))->label(false) ?>
                    <?= $form->field($model, 'companyAddressCity', array('inputOptions'=>['placeholder'=>'Ort']))->label(false) ?>

                    <?= $form->field($model, 'companySector')->dropDownList($sectors, ['prompt'=>'Branche wählen' /*, "0"=>['disabled' => true]*/ ])->label('Branche') ?>  <? //TODO: Make Prompt disabled?>
                    <?= $form->field($model, 'companyEmployees')->dropDownList($employeeAmount, ['prompt'=>'Anzahl der Beschäftigten' ])->label('Anzahl der Mitarbeiter') ?>
                </div>


                <div class="form-group">
                    <?= Html::submitButton('Signup', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>



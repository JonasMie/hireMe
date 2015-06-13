<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $loginModel \common\models\LoginForm */
/* @var $signupModel frontend\models\SignupForm */


// Include JS //
$this->registerJsFile("https://apis.google.com/js/platform.js", array('async'=>'', 'defer'=>''));//, 'position'=>'POS_BEGIN'));
// Include Meta-Tags //
$this->registerMetaTag(array('name' =>'google-signin-client_id', 'content'=>'58721707988-v5app0rim8mk4pqan11dq8hh95nvph2o.apps.googleusercontent.com'));
$this->title = 'Login';
/*$this->params['breadcrumbs'][] = $this->title;*/

// SignUp //
include Yii::getAlias('@helper/companySignup.php');

?>
<div class="site-login">
	
	<!-- Login Full-Page -->

    <div class="row">
        <div class="col-sm-4 col-sm-offset-1 login-field">
			<h2><?= Html::encode($this->title) ?></h2>
		
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($loginModel, 'email', ['inputOptions' => ['autofocus'=>'autofocus','placeholder' => $loginModel->getAttributeLabel('E-Mail')]])->label('E-Mail'); ?>
            <?= $form->field($loginModel, 'password', ['inputOptions' => ['placeholder' => $loginModel->getAttributeLabel('Passwort')]])->passwordInput()->label('Passwort'); ?>
            <?= $form->field($loginModel, 'rememberMe')->checkbox() ?>


            <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-success login-button', 'name' => 'login-button']) ?>
					<?= Html::a('Passwort vergessen?', ['site/request-password-reset']) ?>
                </div>
            <?php ActiveForm::end(); ?>
		
			<?= yii\authclient\widgets\AuthChoice::widget([
				'baseAuthUrl' => ['site/auth'],
				'popupMode' => false
			]) ?>
			
        </div>
		
		<div class="col-sm-4 col-sm-offset-2 login-field">
		
			<h2>Registrierung</h2>
            <?// Signup Form //?>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($signupModel, 'firstName',['inputOptions' => ['placeholder' => $signupModel->getAttributeLabel('Vorname')]])->label('Vorname'); ?>
            <?= $form->field($signupModel, 'lastName',['inputOptions' => ['placeholder' => $signupModel->getAttributeLabel('Nachname')]])->label('Nachname'); ?>
            <?= $form->field($signupModel, 'email',['inputOptions' => ['placeholder' => $signupModel->getAttributeLabel('E-Mail')]])->label('E-Mail'); ?>
            <?= $form->field($signupModel, 'password',['inputOptions' => ['placeholder' => $signupModel->getAttributeLabel('Passwort')]])->label('Passwort')->passwordInput() ?>



            <br>
            <?= $form->field($signupModel, 'checkCompanySignup')->checkbox(array('id'=>'checkCompanySignup'))->label('Als Recruiter registrieren') ?>


            <!-- Additional Information for recruiter signups -->


            <div class="companySetup" style="display: none">    <? //STYLE: display in css?>
                <?= $form->field($signupModel, 'companyName',['inputOptions' => ['placeholder' => $signupModel->getAttributeLabel('Name des Unternehmens')]])->label('Name des Unternehmens'); ?>
                <?= $form->field($signupModel, 'companyAddress',['inputOptions' => ['placeholder' => $signupModel->getAttributeLabel('Anschrift des Unternehmens')]])->label('Anschrift des Unternehmens'); ?>


                <div class="row">
                    <div class="col-lg-9">
                        <?= $form->field($signupModel, 'companyAddressStreet', array('inputOptions'=>['placeholder'=>'Straße']))->label('Straße') ?>
                    </div>
                    <div class="col-lg-3">
                        <?= $form->field($signupModel, 'companyAddressNumber', array('inputOptions'=>['placeholder'=>'Nr.']))->label('Nr.')?>
                    </div>
                </div>
                <?= $form->field($signupModel, 'companyAddressZIP', array('inputOptions'=>['placeholder'=>'PLZ']))->label('PLZ') ?>
                <?= $form->field($signupModel, 'companyAddressCity', array('inputOptions'=>['placeholder'=>'Ort']))->label('Ort') ?>

                <?= $form->field($signupModel, 'companySector')->dropDownList($sectors, ['prompt'=>'Branche wählen' /*, "0"=>['disabled' => true]*/ ])->label('Branche') ?>  <? //TODO: Make Prompt disabled?>
                <?= $form->field($signupModel, 'companyEmployees')->dropDownList($employeeAmount, ['prompt'=>'Anzahl der Beschäftigten' ])->label('Anzahl der Mitarbeiter') ?>
            </div>


            <div class="form-group">
                <?= Html::submitButton('Registrieren', ['class' => 'btn btn-success login-button', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
		
    </div>
</div>

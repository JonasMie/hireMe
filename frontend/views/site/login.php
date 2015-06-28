<?php
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $loginModel \common\models\LoginForm */
/* @var $signupModel frontend\models\SignupForm */

$this->title = 'Login';

// SignUp //
include Yii::getAlias('@helper/companySignup.php');
?>
<div class="site-login">

    <!-- Login Full-Page -->

    <div class="row">
        <div class="col-sm-4 col-sm-offset-1 login-field">
            <h2><?= Html::encode($this->title) ?></h2>

            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= $form->field($loginModel, 'email', ['inputOptions' => ['class' => 'form-control typeStart']])->label('E-Mail'); ?>
            <?= $form->field($loginModel, 'password')->passwordInput()->label('Passwort'); ?>
            <?= $form->field($loginModel, 'rememberMe')->checkbox()->label('Angemeldet bleiben'); ?>


            <div class="form-group SubmitLogin">
                <?= Html::submitButton('Login', ['class' => 'btn btn-success login-button', 'name' => 'login-button']) ?>
            </div>

            <div class="requestNewPassword">
                <?= Html::a('Passwort vergessen?', ['site/request-password-reset']) ?>
            </div>

            <?php ActiveForm::end(); ?>

            <h2 class="socialLoginHeader">Oder melde dich an mit:</h2>

            <?= yii\authclient\widgets\AuthChoice::widget([
                'baseAuthUrl' => ['site/auth'],
                'popupMode'   => false
            ]) ?>

        </div>

        <div class="col-sm-4 col-sm-offset-2 login-field">

            <h2>Registrierung</h2>
            <? // Signup Form //?>

            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($signupModel, 'firstName')->label('Vorname'); ?>
            <?= $form->field($signupModel, 'lastName')->label('Nachname'); ?>
            <?= $form->field($signupModel, 'email')->label('E-Mail'); ?>
            <?= $form->field($signupModel, 'password')->label('Passwort')->passwordInput() ?>
            <?= $form->field($signupModel, 'password_repeat')->label('Passwort wiederholen ')->passwordInput() ?>

            <br>
            <?= $form->field($signupModel, 'checkCompanySignup')->checkbox(array('id' => 'checkCompanySignup'))->label('Als Recruiter registrieren') ?>


            <!-- Additional Information for recruiter signups -->


            <div class="companySetup" style="display: none">
                <?= $form->field($signupModel, 'companyName')->widget(Typeahead::className(), [
                    'name'       => 'companyName',
                    'dataset'    => [
                        [
                            'remote' => Url::to(['site/company-search' . '?q=%QUERY']),
                            'limit'  => 10,
                        ],
                    ],
                    'pluginEvents' => [
                        "typeahead:selected"      => "function(ev,val) {selVal=val.value;jQuery('.companySetup>:not(.field-signupform-companyname)').hide();jQuery('#signupform-companyname').keyup(function(e){
   if(e.which==13) return;if($(this).val()!= selVal){jQuery('.companySetup>:not(.field-signupform-companyname)').show()};
});}",
                        "typeahead:change" => "function(e,val) { console.log(val, value, value==val)  }",
                    ]])->label('Name des Unternehmens') ?>

                <div class="row">
                    <div class="col-lg-9">
                        <?= $form->field($signupModel, 'companyAddressStreet')->label('Straße') ?>
                    </div>
                    <div class="col-lg-3">
                        <?= $form->field($signupModel, 'companyAddressNumber')->label('Nr.') ?>
                    </div>
                </div>

                <?
                $template =
                    '<p>{{plz}}  -  {{city}}</p>';

                echo $form->field($signupModel, 'companyAddressZIP')->widget(Typeahead::className(), [
                    'name'         => 'companyAddressCity',
                    'dataset'      => [
                        [
                            'remote'    => ['url' => Url::to(['site/geo-search' . '?q=%QUERY'])],
                            'limit'     => 10,
                            'templates' => [
                                'empty'      => '<div class="text-error">Es wurde leider kein Ort gefunden.</div>',
                                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                            ],
                            'displayKey' => 'plz',
                        ],
                    ],
                    'pluginEvents' => [
                        'typeahead:selected' => 'function(e,val) { jQuery("#signupform-companyaddresscity").val(val.city) }'
                    ],
                ])->label('PLZ') ?>

                <?
                $template =
                    '<p>{{plz}}  -  {{city}}</p>';

                echo $form->field($signupModel, 'companyAddressCity')->widget(Typeahead::className(), [
                    'name'         => 'companyAddressCity',
                    'dataset'      => [
                        [
                            'remote'    => ['url' => Url::to(['site/geo-search' . '?q=%QUERY'])],
                            'limit'     => 10,
                            'templates' => [
                                'empty'      => '<div class="text-error">Es wurde leider kein Ort gefunden.</div>',
                                'suggestion' => new JsExpression("Handlebars.compile('{$template}')")
                            ],
                            'displayKey' => 'city',
                        ],
                    ],
                    'pluginEvents' => [
                        'typeahead:selected' => 'function(e,val) { jQuery("#signupform-companyaddresszip").val(val.plz) }'
                    ],
                ])->label('Ort') ?>


                <?= $form->field($signupModel, 'companySector')->widget(\kartik\select2\Select2::className(), [
                    'data' => $sectors,
                    'options' => ['prompt' => ''],
                ])->label('Branche') ?>
                <?= $form->field($signupModel, 'companyEmployees')->widget(\kartik\select2\Select2::className(), [
                    'data' => $employeeAmount,
                    'options' => ['prompt' => ''],
                    'hideSearch' => true,
                ])->label('Anzahl der Mitarbeiter') ?>
            </div>


            <div class="form-group">
                <?= Html::submitButton('Registrieren', ['class' => 'btn btn-success login-button', 'name' => 'signup-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>

    </div>
</div>

<? if(!empty($signupModel->errors) && $signupModel->checkCompanySignup){        // make sure to show initially hidden company signup div, if errors occur
    $this->registerJs("$('.companySetup').show();");
}

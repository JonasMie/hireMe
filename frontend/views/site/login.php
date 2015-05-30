<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;
use yii\bootstrap\Modal;
use frontend\assets\SignupAsset;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

// Include JS //
$this->registerJsFile("https://apis.google.com/js/platform.js", array('async'=>'', 'defer'=>''));//, 'position'=>'POS_BEGIN'));
// Include Meta-Tags //
$this->registerMetaTag(array('name' =>'google-signin-client_id', 'content'=>'58721707988-v5app0rim8mk4pqan11dq8hh95nvph2o.apps.googleusercontent.com'));
$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

// SignUp //
include Yii::getAlias('@helper/companySignup.php');
SignupAsset::register($this);

?>
<div class="site-login">
	
	<!-- Login Full-Page -->

    <div class="row">
        <div class="col-sm-4 col-sm-offset-1 login-field">
			<h1><?= Html::encode($this->title) ?></h1>
		
            <?php $form = ActiveForm::begin(['id' => 'login-form','layout' => 'horizontal']); ?>
                <?= $form->field($model, 'email', ['template' => '{label} <div class="row"><div class="">{input}{error}{hint}</div></div>','inputOptions' => ['placeholder' => $model->getAttributeLabel('E-Mail')]])->label(false); ?>
                <?= $form->field($model, 'password', ['template' => '{label} <div class="row"><div class="">{input}{error}{hint}</div></div>','inputOptions' => ['placeholder' => $model->getAttributeLabel('Passwort')]])->passwordInput()->label(false); ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
				
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
		
			<h2>SignUp Formular</h2>
		
		</div>
		
    </div>
	
	
	<!-- Peter Login Modal Test -->
	<?php
	
	Modal::begin([
		'header' => '<h2>Hello world</h2>',
		'toggleButton' => ['label' => 'click me'],
	]);

	?>

	<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
		<?= $form->field($model, 'email') ?>
		<?= $form->field($model, 'password')->passwordInput() ?>
		<?= $form->field($model, 'rememberMe')->checkbox() ?>
		<div style="color:#999;margin:1em 0">
			If you forgot your password you can <?= Html::a('reset it', ['site/request-password-reset']) ?>.
		</div>
		<div class="form-group">
			<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
		</div>
	<?php ActiveForm::end(); ?>
	
	<hr>
    <p><?= Yii::t('app', "Or login using another service:") ?></p>

    <?= yii\authclient\widgets\AuthChoice::widget([
        'baseAuthUrl' => ['site/auth'],
        'popupMode' => false,
    ]) ?>
	
	<?php
	Modal::end();
	
	?>
</div>

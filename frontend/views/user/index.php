<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $jobDataProvider \yii\data\ActiveDataProvider */
/* @var $schoolDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = "Profil";

?>
<div class="row">
	<div class="col-sm-6 user-info">
    <h1><?= /*$user->fullName*/
        $user->fullName?></h1>
	</div>
</div>
<div class="row">
    <div class="col-sm-3 user-picture">
        <?= $user->getProfilePicture() ?>

        <? if ($user->id !== Yii::$app->user->identity->getId()) {
            echo Html::a('Nachricht senden', '/message/create?rec=' . $user->id,['class' => 'btn btn-success ripple']);
			} else {
			echo Html::a('Einstellungen', '/user/settings',['class' => 'btn btn-success ripple']);
        }
        ?>
    </div>
	<div class="col-sm-9 user-timeline">
		<?
		if ($user->getId() == Yii::$app->user->identity->getId()) {

			echo $this->render('/resume/_resume',[
				'jobDataProvider'    => $jobDataProvider,
				'schoolDataProvider' => $schoolDataProvider,
				'edit' => false,
				'label' => 'Bearbeiten',
				'url1' =>['/resume'],
				'url2' =>['/resume']
			]);
		}
		?>
	</div>
</div>

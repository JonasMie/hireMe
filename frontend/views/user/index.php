<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $jobDataProvider \yii\data\ActiveDataProvider */
/* @var $schoolDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = "Profil";
Yii::$app->getSession()->getFlash('error');
?>
<div class="row">
	<div class="col-sm-12 user-info">
    <h1><?= $user->fullName?></h1>
	</div>
</div>
<div class="row first">
    <div class="col-sm-4 user-picture">
        <?= $user->getProfilePicture() ?>

        <? if ($user->id !== Yii::$app->user->identity->getId()) {
            echo Html::a('Nachricht senden', '/message/create?rec=' . $user->id,['class' => 'btn btn-success ripple']);
			} else {
			echo Html::a('Einstellungen', '/user/settings',['class' => 'btn btn-success ripple']);
        }
        ?>
    </div>
	<div class="col-sm-4 currentJob">
		<?
        // only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
        if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {

			echo $this->render('/resume/_resume',[
				'jobDataProvider'    => $jobDataProvider,
				'schoolDataProvider' => $schoolDataProvider,
                'currentJobsDataProvider'        => $currentJobsDataProvider,
                'currentSchoolsDataProvider'     => $currentSchoolsDataProvider,
				'edit' => false,
				'label' => 'Bearbeiten',
				'url1' =>['/resume'],
				'url2' =>['/resume'],
				'order' => 'currentJob'
			]);
		} else {
            echo "<p>Der Nutzer hat seine Informationen nicht veröffentlicht.";
        }
		?>
	</div>
	<div class="col-sm-4 currentSchool">
		<?
        // only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
        if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {

			echo $this->render('/resume/_resume',[
				'jobDataProvider'    => $jobDataProvider,
				'schoolDataProvider' => $schoolDataProvider,
                'currentJobsDataProvider'        => $currentJobsDataProvider,
                'currentSchoolsDataProvider'     => $currentSchoolsDataProvider,
				'edit' => false,
				'label' => 'Bearbeiten',
				'url1' =>['/resume'],
				'url2' =>['/resume'],
				'order' => 'currentSchool'
			]);
		} else {
            echo "<p>Der Nutzer hat seine Informationen nicht veröffentlicht.";
        }
		?>
	</div>
</div>
<div class="row second">
	<div class="col-sm-6 fullJob">
		<?
        // only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
        if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {

			echo $this->render('/resume/_resume',[
				'jobDataProvider'    => $jobDataProvider,
				'schoolDataProvider' => $schoolDataProvider,
                'currentJobsDataProvider'        => $currentJobsDataProvider,
                'currentSchoolsDataProvider'     => $currentSchoolsDataProvider,
				'edit' => false,
				'label' => 'Bearbeiten',
				'url1' =>['/resume'],
				'url2' =>['/resume'],
				'order' => 'fullJob'
			]);
		} else {
            echo "<p>Der Nutzer hat seine Informationen nicht veröffentlicht.";
        }
		?>
	</div>
	<div class="col-sm-6 fullSchool">
		<?
        // only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
        if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {

			echo $this->render('/resume/_resume',[
				'jobDataProvider'    => $jobDataProvider,
				'schoolDataProvider' => $schoolDataProvider,
                'currentJobsDataProvider'        => $currentJobsDataProvider,
                'currentSchoolsDataProvider'     => $currentSchoolsDataProvider,
				'edit' => false,
				'label' => 'Bearbeiten',
				'url1' =>['/resume'],
				'url2' =>['/resume'],
				'order' => 'fullSchool'
			]);
		} else {
            echo "<p>Der Nutzer hat seine Informationen nicht veröffentlicht.";
        }
		?>
	</div>
</div>


<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $jobDataProvider \yii\data\ActiveDataProvider */
/* @var $schoolDataProvider \yii\data\ActiveDataProvider */
/* @var $currentSchoolsDataProvider \yii\data\ActiveDataProvider */
/* @var $currentJobsDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = $user->fullName;
Yii::$app->getSession()->getFlash('error');
?>
<div class="row name">
    <div class="col-sm-4 user-info">
        <h1><?= $user->fullName ?></h1>
    </div>
</div>

<? if($currentJobsDataProvider->getCount() > 0  || $currentSchoolsDataProvider->getCount() > 0 ): ?>

<div class="row first">
    <div class="col-sm-4 user-picture">
        <?= $user->getProfilePicture() ?>
    </div>
    <div class="col-sm-4 currentJob">
        <?
        // only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
        if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {

        echo $this->render('/resume/_resume', [
            'jobDataProvider'            => $jobDataProvider,
            'schoolDataProvider'         => $schoolDataProvider,
            'currentJobsDataProvider'    => $currentJobsDataProvider,
            'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
            'edit'                       => false,
            'label'                      => 'Bearbeiten',
            'url1'                       => ['/resume'],
            'url2'                       => ['/resume'],
            'order'                      => 'currentJob',
            'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
        ]);
        ?>
    </div>
    <div class="col-sm-4 currentSchool">
        <?
        echo $this->render('/resume/_resume', [
            'jobDataProvider'            => $jobDataProvider,
            'schoolDataProvider'         => $schoolDataProvider,
            'currentJobsDataProvider'    => $currentJobsDataProvider,
            'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
            'edit'                       => false,
            'label'                      => 'Bearbeiten',
            'url1'                       => ['/resume'],
            'url2'                       => ['/resume'],
            'order'                      => 'currentSchool',
            'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
        ]);
        }
        ?>
    </div>
</div>
<div class="row second">
    <div class="col-sm-4 userProfileSettings">
        <div class="row">
            <? if ($user->id !== Yii::$app->user->identity->getId()) {
                echo Html::a('Nachricht senden', '/message/create?rec=' . $user->id, ['class' => 'btn btn-success ripple']);
            } else {
                echo Html::a('Profil-Einstellungen', '/user/settings', ['class' => 'btn btn-success ripple']);
            }
            ?>
            <? if ($user->id == Yii::$app->user->identity->getId()) {
                echo Html::a('Lebenslauf bearbeiten', '/resume', ['class' => 'btn btn-success ripple']);
            }
            ?>
        </div>
    </div>
    <div class="col-sm-4 fullJob">
        <?
        // only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
        if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {
        echo $this->render('/resume/_resume', [
            'jobDataProvider'            => $jobDataProvider,
            'schoolDataProvider'         => $schoolDataProvider,
            'currentJobsDataProvider'    => $currentJobsDataProvider,
            'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
            'edit'                       => false,
            'label'                      => 'Bearbeiten',
            'url1'                       => ['/resume'],
            'url2'                       => ['/resume'],
            'order'                      => 'fullJob',
            'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
        ]);
        ?>
    </div>
    <div class="col-sm-4 fullSchool">
        <?
        echo $this->render('/resume/_resume', [
            'jobDataProvider'            => $jobDataProvider,
            'schoolDataProvider'         => $schoolDataProvider,
            'currentJobsDataProvider'    => $currentJobsDataProvider,
            'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
            'edit'                       => false,
            'label'                      => 'Bearbeiten',
            'url1'                       => ['/resume'],
            'url2'                       => ['/resume'],
            'order'                      => 'fullSchool',
            'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
        ]);
        } else {
            echo "<p>Der Nutzer hat seine Informationen nicht veröffentlicht.";
        }
        ?>
    </div>
</div>

<? else: ?>

<div class="row first">
	<div class="col-sm-4">
		<div class="row">
			<div class="col-sm-12 user-picture">
				<?= $user->getProfilePicture() ?>
			</div>
			<div class="col-sm-12 userProfileSettings">
				<div class="row">
					<? if ($user->id !== Yii::$app->user->identity->getId()) {
						echo Html::a('Nachricht senden', '/message/create?rec=' . $user->id, ['class' => 'btn btn-success ripple']);
					} else {
						echo Html::a('Profil-Einstellungen', '/user/settings', ['class' => 'btn btn-success ripple']);
					}
					?>
					<? if ($user->id == Yii::$app->user->identity->getId()) {
						echo Html::a('Lebenslauf bearbeiten', '/resume', ['class' => 'btn btn-success ripple']);
					}
					?>
				</div>
			</div>
		</div>
	</div>
    <div class="col-sm-4 fullJob">
        <?
        // only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
        if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {
        echo $this->render('/resume/_resume', [
            'jobDataProvider'            => $jobDataProvider,
            'schoolDataProvider'         => $schoolDataProvider,
            'currentJobsDataProvider'    => $currentJobsDataProvider,
            'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
            'edit'                       => false,
            'label'                      => 'Bearbeiten',
            'url1'                       => ['/resume'],
            'url2'                       => ['/resume'],
            'order'                      => 'fullJob',
            'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
        ]);
        ?>
    </div>
    <div class="col-sm-4 fullSchool">
        <?
        echo $this->render('/resume/_resume', [
            'jobDataProvider'            => $jobDataProvider,
            'schoolDataProvider'         => $schoolDataProvider,
            'currentJobsDataProvider'    => $currentJobsDataProvider,
            'currentSchoolsDataProvider' => $currentSchoolsDataProvider,
            'edit'                       => false,
            'label'                      => 'Bearbeiten',
            'url1'                       => ['/resume'],
            'url2'                       => ['/resume'],
            'order'                      => 'fullSchool',
            'showButtons'                => $user->getId() == Yii::$app->user->identity->getId()
        ]);
        } else {
            echo "<p>Der Nutzer hat seine Informationen nicht veröffentlicht.";
        }
        ?>
    </div>
</div>

<? endif; ?>
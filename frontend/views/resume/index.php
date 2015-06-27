<?php
use yii\helpers\Html;

/**
 * @var $jobDataProvider \yii\data\ActiveDataProvider
 * @var $schoolDataProvider \yii\data\ActiveDataProvider
 * @var $currentJobsDataProvider \yii\data\ActiveDataProvider
 * @var $currentSchoolsDataProvider \yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Lebenslauf');


?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>
		<div class="row second">
			<div class="col-sm-4 fullJob">
				<?
				// only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'

					echo $this->render('_resume',[
						'jobDataProvider'    => $jobDataProvider,
						'schoolDataProvider' => $schoolDataProvider,
						'currentJobsDataProvider'        => $currentJobsDataProvider,
						'currentSchoolsDataProvider'     => $currentSchoolsDataProvider,
						'edit' => true,
						'label' => 'Eintrag hinzufügen',
						'url1' => ['create', 'type'=>'job'],
						'url2' => ['create', 'type'=>'school'],
						'order' => 'fullJob'
					]);
				?>
			</div>
			<div class="col-sm-4 col-sm-offset-2 fullSchool">
				<?
				// only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'

					echo $this->render('_resume',[
						'jobDataProvider'    => $jobDataProvider,
						'schoolDataProvider' => $schoolDataProvider,
						'currentJobsDataProvider'        => $currentJobsDataProvider,
						'currentSchoolsDataProvider'     => $currentSchoolsDataProvider,
						'edit' => true,
						'label' => 'Eintrag hinzufügen',
						'url1' => ['create', 'type'=>'job'],
						'url2' => ['create', 'type'=>'school'],
						'order' => 'fullSchool'
					]);
				?>
			</div>
		</div>
</div>
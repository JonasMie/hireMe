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

    <?=
    $this->render('_resume', [
        'jobDataProvider'    => $jobDataProvider,
        'schoolDataProvider' => $schoolDataProvider,
        'currentJobsDataProvider'        => $currentJobsDataProvider,
        'currentSchoolsDataProvider'     => $currentSchoolsDataProvider,
        'edit' => true,
        'label' => 'Eintrag hinzufügen',
        'url1' => ['create', 'type'=>'job'],
        'url2' => ['create', 'type'=>'school'],
		'order' => 'profile'
    ])
    ?>

</div>
<?php
use yii\helpers\Html;

/**
 * @var $jobDataProvider \yii\data\ActiveDataProvider
 * @var $schoolDataProvider \yii\data\ActiveDataProvider
 */

$this->title = Yii::t('app', 'Lebenslauf');
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="resume-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?=
    $this->render('_resume', [
        'jobDataProvider'    => $jobDataProvider,
        'schoolDataProvider' => $schoolDataProvider,
        'edit' => true,
        'label' => 'Eintrag hinzufügen',
        'url1' => ['create', 'type'=>'job'],
        'url2' => ['create', 'type'=>'school'],
    ])
    ?>

</div>
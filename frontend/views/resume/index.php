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


    <h2>Berufserfahrung</h2>
    <?php
    echo \yii\widgets\ListView::widget([
       'dataProvider'=>  $jobDataProvider,
        'itemView' => '_resumeJob'
    ]);
    ?>
    <p>
        <?= Html::a(Yii::t('app', 'Eintrag hinzufügen'), ['create', 'type'=>'work'], ['class' => 'btn btn-success']) ?>
    </p>
    <h2>Schulische Laufbahn</h2>
    <?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>  $schoolDataProvider,
        'itemView' => '_resumeSchool'
    ]);
    ?>
    <p>
        <?= Html::a(Yii::t('app', 'Eintrag hinzufügen'), ['create', 'type'=>'school'], ['class' => 'btn btn-success']) ?>
    </p>
</div>
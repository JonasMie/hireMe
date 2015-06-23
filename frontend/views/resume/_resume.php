<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 09.06.15
 * Time: 22:46
 * Project: hireMe
 */

/**
 * @var $jobDataProvider \yii\data\ActiveDataProvider
 * @var $schoolDataProvider \yii\data\ActiveDataProvider
 * @var $edit boolean
 * @var $label String
 * @var $url1 Array
 * @var $url2 Array
 * @var $currentJobsDataProvider \yii\data\ActiveDataProvider
 * @var $currentSchoolsDataProvider \yii\data\ActiveDataProvider
 * @var $order String
 */

use yii\helpers\Html;

?>
<?php if ($order=='currentJob'): ?>

<?php
$currentJobs = $currentJobsDataProvider->getCount();
$currentSchools = $currentSchoolsDataProvider->getCount();

if ($currentJobs > 0) {
    echo "<h2>Aktuelle Beschäftigung</h2>";
}
if ($currentJobs) {
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $currentJobsDataProvider,
        'itemView'     => '_resumeJob',
        'viewParams'   => ['edit' => $edit],
    ]);
}
?>

<?php elseif ($order=='currentSchool'): ?>

<?php
$currentJobs = $currentJobsDataProvider->getCount();
$currentSchools = $currentSchoolsDataProvider->getCount();

if ($currentSchools > 0) {
    echo "<h2>Letzter Abschluss</h2>";
}
if ($currentSchools) {
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $currentSchoolsDataProvider,
        'itemView'     => '_resumeSchool',
        'viewParams'   => ['edit' => $edit],
    ]);
}
?>

<?php elseif ($order=='fullJob'): ?>

<?php
$currentJobs = $currentJobsDataProvider->getCount();
$currentSchools = $currentSchoolsDataProvider->getCount();
?>
<h2>Berufserfahrung</h2>
<?php
echo \yii\widgets\ListView::widget([
    'dataProvider' => $jobDataProvider,
    'itemView'     => '_resumeJob',
    'viewParams'   => ['edit' => $edit],
]);
?>
<p>
    <?= Html::a(Yii::t('app', $label), $url1, ['class' => 'btn btn-success ripple']) ?>
</p>


<?php elseif ($order=='fullSchool'): ?>

<?php
$currentJobs = $currentJobsDataProvider->getCount();
$currentSchools = $currentSchoolsDataProvider->getCount();
?>
<h2>Ausbildung</h2>
<?php
echo \yii\widgets\ListView::widget([
    'dataProvider' => $schoolDataProvider,
    'itemView'     => '_resumeSchool',
    'viewParams'   => ['edit' => $edit],
]);
?>
<p>
    <?= Html::a(Yii::t('app', $label), $url2, ['class' => 'btn btn-success ripple']) ?>
</p>

<?php else: ?>

<?php
$currentJobs = $currentJobsDataProvider->getCount();
$currentSchools = $currentSchoolsDataProvider->getCount();

if ($currentJobs + $currentSchools > 0) {
    echo "<h2>Aktuell</h2>";
}
if ($currentJobs) {
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $currentJobsDataProvider,
        'itemView'     => '_resumeJob',
        'viewParams'   => ['edit' => $edit],
    ]);
}
if ($currentSchools) {
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $currentSchoolsDataProvider,
        'itemView'     => '_resumeSchool',
        'viewParams'   => ['edit' => $edit],
    ]);
}
?>

<h2>Berufserfahrung</h2>
<?php
echo \yii\widgets\ListView::widget([
    'dataProvider' => $jobDataProvider,
    'itemView'     => '_resumeJob',
    'viewParams'   => ['edit' => $edit],
]);
?>
<p>
    <?= Html::a(Yii::t('app', $label), $url1, ['class' => 'btn btn-success ripple']) ?>
</p>
<h2>Ausbildung</h2>
<?php
echo \yii\widgets\ListView::widget([
    'dataProvider' => $schoolDataProvider,
    'itemView'     => '_resumeSchool',
    'viewParams'   => ['edit' => $edit],
]);
?>
<p>
    <?= Html::a(Yii::t('app', $label), $url2, ['class' => 'btn btn-success ripple']) ?>
</p>

<?php endif; ?>
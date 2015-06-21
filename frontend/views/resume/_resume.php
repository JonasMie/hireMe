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
 */

use yii\helpers\Html;

?>
<!-- Initializing Foo Tables -->
<? $this->registerJS(
    "$(function () {
        $('.footable').footable({
            breakpoints: {
                /* Somehow Footable misses the screen wdtdh by 31 Pixels */
                mediaXXsmall: 480,
                mediaXsmall: 736,
                mediaSmall: 960

            }
        });
    });");

?>

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
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

<? /* Most Recent Job/Jobs */ ?>

<?php if ($order == 'currentJob'): ?>

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
            'options'      => [
                'class' => 'allowPrefill list-view',
            ],
        ]);
    }
    ?>

    <? /* Most Recent Graduation/Highest Qualification */ ?>

<?php elseif ($order == 'currentSchool'): ?>

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
            'options'      => [
                'class' => 'allowPrefill list-view',
            ],
        ]);
    }
    ?>

    <? /* Full List of Jobs */ ?>

<?php elseif ($order == 'fullJob'): ?>
    <h2>Berufserfahrung</h2>
    <?php
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $jobDataProvider,
        'itemView'     => '_resumeJob',
        'viewParams'   => ['edit' => $edit],
        'options'      => [
            'class' => 'allowPrefill list-view',
        ],
        ]);
    ?>

    <? if ($showButtons): ?>
        <div class="insertJobData">
            <?= Html::a(Yii::t('app', $label), $url1, ['class' => 'btn btn-success ripple insertJobData']) ?>
        </div>
    <? endif ?>
    <? /* Full List of Education */ ?>

<?php elseif ($order == 'fullSchool'): ?>

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
        'options'      => [
            'class' => 'allowPrefill list-view',
        ],
    ]);
    ?>
    <? if ($showButtons): ?>
        <div class="insertSchoolData">
            <?= Html::a(Yii::t('app', $label), $url2, ['class' => 'btn btn-success ripple insertSchoolData']) ?>
        </div>
    <? endif ?>

    <? /* Default Fallback View for Resume when none of the options (order=...) above is selected */ ?>

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

    <? if ($showButtons): ?>
        <p>
            <?= Html::a(Yii::t('app', $label), $url1, ['class' => 'btn btn-success ripple']) ?>
        </p>
    <? endif ?>

    <h2>Ausbildung</h2>
    <?php
    echo \yii\widgets\ListView::widget([
        'dataProvider' => $schoolDataProvider,
        'itemView'     => '_resumeSchool',
        'viewParams'   => ['edit' => $edit],
    ]);
    ?>
    <? if ($showButtons): ?>
        <p>
            <?= Html::a(Yii::t('app', $label), $url2, ['class' => 'btn btn-success ripple']) ?>
        </p>
    <? endif ?>
<?php endif; ?>
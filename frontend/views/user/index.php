<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ListView;

$this->title = "Profil";
$this->params['breadcrumbs'][] = $this->title;

?>
    <h1><?= /*$user->fullName*/
        $user->firstName . " " . $user->lastName   //TODO: use fullName      ?></h1>

    <div>
        <?= Html::img("http://www.francis-consulting.com/files/8814/2987/8012/avater.jpg", [   // TODO: image
            'height' => '150px',
            'width'  => '150px'
        ]); ?>

        <? if ($user->id !== Yii::$app->user->identity->getId()) {
            echo Html::button(Html::a('Nachricht senden', '/message/create?rec=' . $user->id));
        } else {
            echo Html::button(Html::a('Einstellungen', '/user/settings'));
        }
        ?>
    </div>
<?
echo "<div>";
if ($user->getId() == Yii::$app->user->identity->getId()) {
    if (!empty($resumeJob)) {
        foreach ($resumeJob as $job) {
            if (isset($job->current) && $job->current) {
                echo "<h2>Aktuell</h2>";            // TODO: only once
                echo Html::a($job->type, 'search/?type=' . $job->type, ['class' => 'test']); // TODO: check URL
                echo "<br>";
                echo Html::a($job->company->name, 'company/?id=' . $job->company->id);   // TODO: review URL
            }
        }

        echo "<h2>Berufserfahrung</h2>";
        foreach ($resumeJob as $job) {
            echo "<div>";
            echo Html::a($job->type, 'search/?type=' . $job->type, ['class' => 'test']); // TODO: check URL
            echo "<br><div><span>";
            echo Html::a($job->company->name, 'company/?id=' . $job->company->id);   // TODO: review URL
            echo "</span><span>";
            echo Yii::$app->formatter->asDate($job->begin, "MMMM y") ." - ";
            echo $job->end?Yii::$app->formatter->asDate($job->end, "MMMM y"):"heute";
            echo "</span></div></div>";
        }
    }
    if (!empty($resumeSchool)) {
        echo "<h2>Bildung</h2>";
        foreach ($resumeSchool as $school) {
            echo "<p>" . $school->schoolname . "</p>";
            echo "<br>";
            echo "<p>" . $school->graduation . "</p>";
        }
    }
    echo "</div>";
}





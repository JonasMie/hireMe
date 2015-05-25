<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ListView;


?>
    <h1><?= /*$user->fullName*/
        $user->firstName . " " . $user->lastName   //TODO: use fullName    ?></h1>

    <div>
        <?= Html::img("https://www.mi.hdm-stuttgart.de/mib/studium/intern/studienanfaenger/mib_ws1213/Krug_Thomas.jpg", [   // TODO: image
            'height' => '150px',
            'width'  => '150px'
        ]); ?>

        <?= Html::button('Rekrutieren'); // TODO: Funktionalität    ?>
    </div>
<?
echo "<div>";
if ($user->getId() == Yii::$app->user->identity->getId()) {
    foreach ($resumeJob as $job) {
        if (isset($job->current) && $job->current) {
            echo "<h2>Aktuell</h2>";
            echo Html::a($job->type, 'search/?type=' . $job->type, ['class' => 'test']); // TODO: check URL
            echo "<br>";
            echo Html::a($job->company->name, 'company/?id=' . $job->company->id);   // TODO: review URL
        }
    }
    echo "<h2>Berufserfahrung</h2>";
    foreach ($resumeJob as $job) {
        echo Html::a($job->type, 'search/?type=' . $job->type, ['class' => 'test']); // TODO: check URL
        echo "<br>";
        echo Html::a($job->company->name, 'company/?id=' . $job->company->id);   // TODO: review URL
    }
    echo "<h2>Bildung</h2>";
    foreach ($resumeSchool as $school){
        echo "<p>" .$school->schoolname ."</p>";
        echo "<br>";
        echo Html::a($job->company->name, 'company/?id=' . $job->company->id);   // TODO: review URL
    }
    echo "</div>";
}





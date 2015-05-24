<?php
/* @var $this yii\web\View */
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ListView;


?>
<h1><?=  /*$user->fullName*/ $user->firstName ." " .$user->lastName   //TODO: use fullName ?></h1>

<?= Html::img("https://www.mi.hdm-stuttgart.de/mib/studium/intern/studienanfaenger/mib_ws1213/Krug_Thomas.jpg", [   // TODO: image
    'height' => '150px',
    'width' => '150px'
]); ?>

<?= Html::button('Rekrutieren'); // TODO: Funktionalität ?>

<?

    if($user->getId() == Yii::$app->user->identity->getId()){
        foreach ($resumeJob as $job) {
            if (isset($job->current) && $job->current) {
                echo "<p>Aktuell</p>";
                echo Html::a($job->type, 'search/?type=' . $job->type, ['class' => 'test']); // TODO: check URL
                echo Html::a($job->company->name, 'company/?id=' . $job->company->id);   // TODO: review URL
            } else {

            }
        }
    }





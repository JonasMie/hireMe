<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 09.06.15
 * Time: 22:20
 * Project: hireMe
 */


use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ResumeJob */

$this->title = Yii::t('app', 'Ausbildung hinzufügen');
?>
<div class="resume-school-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_schoolResumeForm', [
        'model' => $model,
    ]) ?>

</div>

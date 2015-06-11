<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 09.06.15
 * Time: 22:46
 * Project: hireMe
 */

/* @var $jobDataProvider \yii\data\ActiveDataProvider */
/* @var $schoolDataProvider \yii\data\ActiveDataProvider */
/* @var $edit boolean */
/* @var $label String */
/* @var $url1 Array*/
/* @var $url2 Array*/

use yii\helpers\Html;

?>
<h2>Berufserfahrung</h2>
    <?php
    echo \yii\widgets\ListView::widget([
        'dataProvider'=>  $jobDataProvider,
        'itemView' => '_resumeJob',
        'viewParams' => ['edit' =>$edit],
    ]);
    ?>
<p>
    <?= Html::a(Yii::t('app', $label), $url1, ['class' => 'btn btn-success']) ?>
</p>
<h2>Schulische Laufbahn</h2>
<?php
echo \yii\widgets\ListView::widget([
    'dataProvider'=>  $schoolDataProvider,
    'itemView' => '_resumeSchool',
    'viewParams' => ['edit' =>$edit],
]);
?>
<p>
    <?= Html::a(Yii::t('app', $label), $url2, ['class' => 'btn btn-success']) ?>
</p>
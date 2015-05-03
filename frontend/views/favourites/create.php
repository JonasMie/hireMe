<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Favourites */

$this->title = Yii::t('app', 'Create Favourites');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Favourites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="favourites-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>

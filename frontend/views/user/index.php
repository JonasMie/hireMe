<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $jobDataProvider \yii\data\ActiveDataProvider */
/* @var $schoolDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = "Profil";
$this->params['breadcrumbs'][] = $this->title;

?>
    <h1><?= /*$user->fullName*/
        $user->fullName?></h1>
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
if ($user->getId() == Yii::$app->user->identity->getId()) {

    echo $this->render('/resume/_resume',[
        'jobDataProvider'    => $jobDataProvider,
        'schoolDataProvider' => $schoolDataProvider,
        'edit' => false,
        'label' => 'Bearbeiten',
        'url1' =>['/resume'],
        'url2' =>['/resume'],
    ]);
}





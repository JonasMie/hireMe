<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $jobDataProvider \yii\data\ActiveDataProvider */
/* @var $schoolDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = "Profil";
Yii::$app->getSession()->getFlash('error');
?>

    <h1><?= $user->fullName ?></h1>
    <div>
        <?= $user->getProfilePicture() ?>

        <? if ($user->id !== Yii::$app->user->identity->getId()) {
            echo Html::button(Html::a('Nachricht senden', '/message/create?rec=' . $user->id));
        } else {
            echo Html::button(Html::a('Einstellungen', '/user/settings'));
        }
        ?>
    </div>
<?

// only show profile details, if its my own profile, if user set visibility to 'everyone' or i'm recruiter and user set visibility to 'recruiter only'
if ($user->getId() == Yii::$app->user->identity->getId() || $user->visibility == 2 || $user->visibility == 1 && Yii::$app->user->identity->isRecruiter()) {

    echo $this->render('/resume/_resume', [
        'jobDataProvider'    => $jobDataProvider,
        'schoolDataProvider' => $schoolDataProvider,
        'edit'               => false,
        'label'              => 'Bearbeiten',
        'url1'               => ['/resume'],
        'url2'               => ['/resume'],
    ]);
} else {
    echo "<p>Der Nutzer hat seine Informationen nicht veröffentlicht.";
}





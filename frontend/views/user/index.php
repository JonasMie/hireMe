<?php
/* @var $this yii\web\View */
/* @var $user common\models\User */
/* @var $jobDataProvider \yii\data\ActiveDataProvider */
/* @var $schoolDataProvider \yii\data\ActiveDataProvider */

use yii\helpers\Html;

$this->title = "Profil";

?>
<<<<<<< HEAD
    <h1><?= /*$user->fullName*/
        $user->fullName?></h1>
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

=======
	<div class="row">
		<div class="col-sm-6 user-info">
			<h1><?= /*$user->fullName*/
			$user->firstName . " " . $user->lastName   //TODO: use fullName      ?>
			</h1>
		</div>
	</div>
	<div class="row">
	
		<div class="col-sm-3 user-picture">
			<?= Html::img("http://www.vitamin-ha.com/wp-content/uploads/2013/09/Funny-Profile-Pictures-14.jpg", [   // TODO: image
				'height' => 'auto',
				'width'  => '100%',
				'class' => 'img-rounded'
			]); ?>
>>>>>>> feature/userProfile

			<? if ($user->id !== Yii::$app->user->identity->getId()) {
				echo Html::a('Nachricht senden', '/message/create?rec=' . $user->id,['class' => 'btn btn-lg btn-success']);
			} else {
				echo Html::a('Einstellungen', '/user/settings',['class' => 'btn btn-lg btn-success']);
			}
			?>
		</div>
		
		
		<div class="col-sm-9 user-timeline">
		
		<?
		/* Lebenslauf */
		
		echo "";
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
		}
		?>
		</div>
	</div>


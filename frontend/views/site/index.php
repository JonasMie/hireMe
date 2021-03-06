<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'hireMe';
?>
<div class="row jumbo">
	<div class="full first">
		<div class="jumbotron">
			<h1 class="titel-h1">hireMe</h1>
			<h2 class="titel-h2">Bewerbung mit nur einem Klick</h2>
			<p class="titel-p">Vergiss den Wechsel zwischen Stellenanzeige, Jobportal, Schreibprogramm, Anhängen und E-Mail. Mit dem hireMe-Button bewirbst du dich mit nur einem Klick.</p>
			<a class="btn btn-success ripple" href="/site/login">Jetzt anmelden!</a>
		</div>

	</div>
</div>

<div class="row green">
	<div class="full second">
		<div class="col-sm-5 col-sm-offset-1 slide-left left">
			<h2>Bewerbung mit nur einem Klick</h2>
			<p>Vergiss den Wechsel zwischen Stellenanzeige, Jobportal, Schreibprogramm, Anh&auml;ngen und E-Mail. Mit dem hireMe-Button bewirbst du dich mit nur einem Klick.</p>
		</div>
		
		<div class="col-sm-5 slide-right right">
			
			<?=Html::img("../../images/landingpage/click.png", ['class'=>'img-responsive centered hidden-xs']);?>
			<?=Html::img("../../images/landingpage/click-mobile.png", ['class'=>'img-responsive centered hidden-md hidden-sm hidden-lg']);?>
		</div>
	</div>

</div>

<div class="row black">
	<div class="full second">
		<div class="col-sm-5 col-sm-offset-1 slide-left left">
			<?=Html::img("../../images/landingpage/zentrale-datenablage.png", ['class'=>'img-responsive centered hidden-xs']);?>
			<?=Html::img("../../images/landingpage/zentrale-datenablage-mobile.png", ['class'=>'img-responsive centered hidden-md hidden-sm hidden-lg']);?>
		</div>
	
		<div class="col-sm-5 slide-right right">
			<h2>Zentrale Datenablage</h2>
			<p>Deinen Lebenslauf, deine Arbeitsproben, Empfehlungsschreiben, und Zertifikate speicherst du jetzt sicher online ab. Verf&uuml;gbar, wenn du sie brauchst. Gleichzeitig beh&auml;ltst du hier den &Uuml;berblick &uuml;ber deine Bewerbungen.</p>
		</div>
	</div>

</div>

<div class="row green">
	<div class="full second">
		<div class="col-sm-5 col-sm-offset-1 slide-left left">
			<h2>hireMe-Button</h2>
			<p>Binden Sie schnell und einfach den hireMe-Button auf Ihrer Website ein, um potenziellen Kandidaten den Bewerbungs-Prozess zu erleichtern.</p>
		</div>
	
		<div class="col-sm-5 slide-right right">
			<?=Html::img("../../images/landingpage/button.png", ['class'=>'img-responsive centered hidden-xs']);?>
			<?=Html::img("../../images/landingpage/button-mobile.png", ['class'=>'img-responsive centered hidden-md hidden-sm hidden-lg']);?>
		</div>
	</div>

</div>

<div class="row black">
	<div class="full second">
		<div class="col-sm-5 col-sm-offset-1 slide-left left analytics-pic">
			<?=Html::img("../../images/landingpage/analytics.png", ['class'=>'img-responsive centered hidden-xs']);?>
			<?=Html::img("../../images/landingpage/analytics-mobile.png", ['class'=>'img-responsive centered hidden-md hidden-sm hidden-lg']);?>
		</div>
	
		<div class="col-sm-5 slide-right right">
			<h2>Analytics</h2>
			<p>Wo kommen meine Bewerber her? Wie viele Interessenten bewerben sich auch? Mit den Analytics lassen sich diese Kennzahlen analysieren und optimieren.</p>
		</div>
	</div>

</div>

<div class="row green">
	<div class="full second">
		<div class="col-sm-8 col-sm-offset-2 slide-right align-right">
			<h2>Jetzt loslegen!</h2>
			<p>Nach einer kurzen Registrierung kannst du deine Daten hinterlegen und dich mit dem hireMe-Button bewerben.</p>
			<?=Html::a('Zur Anmeldung','site/login', ['class'=>'btn btn-default ripple']);?>
		</div>
	
		<div class="col-sm-8 col-sm-offset-2 slide-left margin10">
			<h2>Newsletter</h2>
			<p>Melden Sie sich f&uuml;r den Newsletter an um zu erfahren, wann hireMe f&uuml;r Sie da sein wird.</p>
			<div id="mc_embed_signup">
				<form action="//sexy.us10.list-manage.com/subscribe/post?u=8ffea56dd8193b820af7dc04e&amp;id=bcd3849ec0" method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank" novalidate="">
				<div id="mc_embed_signup_scroll">

				<div class="mc-field-group">
				<input type="email" value="" name="EMAIL" class="required email form-control" id="mce-EMAIL" placeholder="E-Mail Adresse">
				</div>
				<div id="mce-responses" class="clear">
				<div class="response" id="mce-error-response" style="display:none"></div>
				<div class="response" id="mce-success-response" style="display:none"></div>
				</div>    <!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
				<div style="position: absolute; left: -5000px;"><input type="text" name="b_8ffea56dd8193b820af7dc04e_bcd3849ec0" tabindex="-1" value=""></div>
				<div class="clear"><input type="submit" value="Anmelden" name="subscribe" id="mc-embedded-subscribe" class="button btn btn-default ripple"></div>
				</div>
				</form>
			</div>
		</div>
	</div>

</div>
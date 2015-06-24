<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        Der Fehler trat auf, während der Webserver Ihre Anfrage bearbeitete.
<!--        The above error occurred while the Web server was processing your request.-->
    </p>
    <p>
        Bitte kontaktieren sie uns, wenn Sie denken, dass es sich um einen Fehler handelt.
<!--        Please contact us if you think this is a server error. Thank you.-->
    </p>

</div>

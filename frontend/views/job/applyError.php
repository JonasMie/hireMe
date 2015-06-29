<?php

use yii\helpers\Html;
use frontend\assets\GiphyAsset;

GiphyAsset::register($this);
?>
<div class="job-index">
<div class="col-sm-12">
<h1>Bewerbung</h1>
    <p>
       <?=$message ?>
    </p>
    Als Entschädigung haben wir hier für dich ein kleines Gif :*
    <br>
    <br>
      <img id="giphy" width="250px" height="250px"></img>
</div>
</div>

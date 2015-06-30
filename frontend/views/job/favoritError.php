<?php

use yii\helpers\Html;
use frontend\assets\GiphyAsset;

GiphyAsset::register($this);

?>
<div class="job-index">
<div class="col-sm-12">
<h1>Bewerbung nicht möglich</h1>
    <p>
      Als Recruiter kannst du keine Favoriten hinzufügen.
      <br><br>
      Als Entschädigung haben wir hier ein kleines Gif für dich :*
      <br>
      <br>
      <img id="giphyFav" width="250px" height="250px"></img>
      <br><br>
      <a href="/dashboard">Zurück zu HireMe</a>
    </p>
</div>
</div>

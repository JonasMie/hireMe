<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Generated Code';
$this->params['breadcrumbs'][] = $this->title;
?>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

		<button id="bButton" >HIRE ME!</button>
		 <p id="us" class="hidden" style="visibility: hidden;"><?= $userID ?></p>
		<script type="text/javascript">

			var user;
			var jobAd;

			$( document ).ready(function() {
					user = document.getElementById("us").innerHTML;
					jobAd = window.name;
					
			});
			$( "#bButton" ).click(function() {
				var url = "http://frontend/job/apply?id="+window.name+"&user="+user;
				window.open(url,'_blank');
			});

		</script>
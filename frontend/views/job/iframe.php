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

		function httpReq(url) {  
			var xmlHttp = new XMLHttpRequest();
    		xmlHttp.open( "GET", url, false );
    		xmlHttp.send( null );
    	}

			var user;
			var jobAd;

			$( document ).ready(function() {
					httpReq("http://frontend/job/view-up?btnKey="+window.name);
					user = document.getElementById("us").innerHTML;
					jobAd = window.name;
					
			});

			$( "#bButton" ).click(function() {
				httpReq("http://frontend/job/click-up?btnKey="+window.name);
				var url = "http://frontend/job/apply?key="+window.name+"&user="+user;
				window.open(url,'_blank');
			});

		</script>
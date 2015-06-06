<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Generated Code';
$this->params['breadcrumbs'][] = $this->title;
?>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		 <p id="us" class="hidden" style="visibility: hidden;"><?= $userID ?></p>
		<script type="text/javascript">
		
		function httpReq(url) {  
			var xmlHttp = new XMLHttpRequest();
    		xmlHttp.open( "GET", url, false );
    		xmlHttp.send( null );
    	}

			var user;
			var jobAd;
			var displayingHTML;

			$( document ).ready(function() {

			user = document.getElementById("us").innerHTML;
			if (user == "NA") {	
			displayingHTML = "<h2>Du bist nicht eingeloggt</h2><br><button id='login'>Hier</button> einloggen";
			$("#applierView").html(displayingHTML);
			}
			else {
			displayingHTML = '<h2>Jetzt bewerben:</h2><br><button id="hireNow">JETZT BEWERBEN</button><br><button id="hireLater">NUR SPEICHERN</button>';
			$("#applierView").html(displayingHTML);
			alert();
			}


		$("#hireNow").on('click' ,function()  { 
   		
			httpReq("http://frontend/job/click-up?btnKey="+window.name);
			var url = "http://frontend/job/apply?key="+window.name+"&user="+user+"&case=1";
			window.open(url,'_blank');

			});
		$("#hireLater").on('click' ,function()  { 
   	
			user = document.getElementById("us").innerHTML;
			httpReq("http://frontend/job/click-up?btnKey="+window.name);
			var url = "http://frontend/job/apply?key="+window.name+"&user="+user+"&case=1";
			window.open(url,'_blank');

			});

		$("#login").on('click', function() {

			var url = "http://frontend/site/login";
			window.open(url,'_blank');
		})
				
		});

			

		</script>

<div id="applierView">


</div>


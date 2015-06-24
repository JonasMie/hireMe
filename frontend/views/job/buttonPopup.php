<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Generated Code';
?>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		 <p id="us" class="hidden" style="visibility: hidden;"><?= $userID ?></p>
		 <p id="applied" class="hidden" style="visibility:hidden;"><?= $applied ?></p>
		<script type="text/javascript">
		
		function httpReq(url) {  
			var xmlHttp = new XMLHttpRequest();
    		xmlHttp.open( "GET", url, false );
    		xmlHttp.send( null );
    	}

			var user;
			var jobAd;
			var applied;
			var displayingHTML;

			$( document ).ready(function() {

			user = document.getElementById("us").innerHTML;
			if (user == "NA") {	
			displayingHTML = "<h2>Du bist nicht eingeloggt</h2><br><button id='login'>Hier</button> einloggen";
			$("#applierView").html(displayingHTML);
			}
			else {
			applied = document.getElementById("applied").innerHTML;
			if(applied == 1) {displayingHTML = "<h2>Du hast bereits eine Bewerbung auf diese Stelle</h2>";}
			else {displayingHTML = '<h2>Jetzt bewerben</h2><br><button id="hireNow">Dateien hinzufügen</button><br><button id="saveFavorit">Als Favorit speichern</button>';}
			$("#applierView").html(displayingHTML);
			}


		$("#hireNow").on('click' ,function()  { 

			httpReq("http://frontend/job/click-up?btnKey="+window.name);
			var url = "http://frontend/job/apply?key="+window.name+"&user="+user;
			//window.open(url,'_blank');
			window.location= url;

			});

		$("#saveFavorit").on('click' ,function()  { 
   	
			user = document.getElementById("us").innerHTML;
			var url = "http://frontend/job/save-favorit?key="+window.name+"&user="+user;
			window.location= url;

			});

		$("#login").on('click', function() {

			var url = "http://frontend/site/login";
			window.open(url,'_blank');
		})
				
		});

			

		</script>

<div id="applierView">


</div>


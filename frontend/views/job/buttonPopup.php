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


			$( document ).ready(function() {


		$("#hireNow").on('click' ,function()  { 
   		
			user = document.getElementById("us").innerHTML;
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
				
		});

			

		</script>


<h2>BEWERBEN</h2>
<p>askjdhasjkdbbasjdbjkasbdbsjakdbkasbdasbjdjasbkdbasbdbasbdasdb</p>

<button id="hireNow">JETZT BEWERBEN</button>
<button id="hireLater">NUR SPEICHERN</button>


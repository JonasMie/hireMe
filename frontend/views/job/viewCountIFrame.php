<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\JobSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Generated Code';
?>
		<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
		<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
  		<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script type="text/javascript">

		function httpReq(url) {  
			var xmlHttp = new XMLHttpRequest();
    		xmlHttp.open( "GET", url, false );
    		xmlHttp.send( null );
    		}

			$( document ).ready(function() {
					httpReq("http://hireme.mi.hdm-stuttgart.de/job/view-up?btnKey="+window.name);
			});
			
		</script>
<?php
use yii\helpers\Html;
/* @var $this yii\web\View */
$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>hireMe</h1>

        <p class="lead">Apply how, where and when you want.</p>
    </div>
	
	<div class="row">
	
	<div class="col-sm-4 col-sm-offset-1">
        <h2>All your applications</h2>

        <p class="lead">On hireMe, once your data is entered, we securely store it in a standardized data format so it can be easily extracted and processed by the recruiter.</p>
    </div>
	
	<div class="col-sm-4 col-sm-offset-2">
        <h2>Just one click</h2>

        <p class="lead">With hireMe, we introduced the hireMe-Button, which you'll soon find on all major job sites.</p>

        <p><?= Html::a('Get started!', ['site/login',],['class' => 'btn btn-lg btn-success']) ?></p>
    </div>

    </div>
</div>

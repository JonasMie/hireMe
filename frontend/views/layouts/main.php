<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link rel="stylesheet" href="/css/stylesheets/style.css">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
</head>
<body>
    <?php $this->beginBody() ?>
    <div class="wrap">

        <nav role="navigation" class="navbar-inverse navbar-fixed-top navbar" id="header">
            <div class="container">
                <div class="navbar-header">
                    <button data-target="#header-collapse" data-toggle="collapse" class="navbar-toggle" type="button"><span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/" class="navbar-brand"><img class="navbar-logo" src="/images/testlogo.png"/></a>
                </div>
                <div class="collapse navbar-collapse" id="header-collapse">
                    <ul class="navbar-nav navbar-right nav" id="w0">
                        <li class="active"><a href="/site/index">Home</a></li>
                        <li><a href="/site/about">About</a></li>
                        <li><a href="/site/contact">Contact</a></li>
                        <li><a href="/site/signup">Signup</a></li>
                        <li><a href="/site/login">Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
        <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\assets\CustomAppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
CustomAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- Hard Coded. Remove this in Application.php
    <link rel="stylesheet" href="/css/stylesheets/style.css">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    -->

    <?php $this->head() ?>
</head>
<body class='<?= Yii::$app->controller->getBodyClasses() ?>'>
<?php $this->beginBody() ?>
<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img id="navbar-logo" src="/images/testlogo.png"/>',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
            'id' => 'header'
        ],
    ]);
    $menuItems = [
        ['label' => 'Home', 'url' => ['/site/index']],
        ['label' => 'About', 'url' => ['/site/about']],

        [
            'label' => 'Dropdown',
            'items' => [
                ['label' => 'Dropdown A', 'url' => '#'],
                ['label' => 'Dropdown B', 'url' => '#'],
                ['label' => 'Dropdown C', 'url' => '#'],
            ],
        ],


        ['label' => 'Contact', 'url' => ['/site/contact']],
    ];
	
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = [
            'label' => 'Logout (' . Yii::$app->user->identity->firstName . ')',
            'url' => ['/site/logout'],
            'linkOptions' => ['data-method' => 'post']
        ];
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

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
        <p class="pull-left">&copy; HireMe <?= date('Y') ?></p>
        <p class="pull-right">
            Made with <span class="glyphicon glyphicon-heart"></span> in Stuttgart


        </p>
        <!--<p class="pull-right"><?= Yii::powered() ?></p>-->
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

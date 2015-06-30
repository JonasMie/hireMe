<?php
use yii\helpers\Html;
use frontend\assets\AppAsset;
use frontend\assets\CustomAppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
CustomAppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<link rel="shortcut icon" href="/css/favicon.ico" type="image/x-icon" />
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>

    <!-- Hard Coded. Remove this in Application.php
    <link rel="stylesheet" href="/css/stylesheets/style.css">
    <link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" type="text/javascript"></script>
    <script src="/js/footable.js"></script>
    <script src="/js/customScript.js"></script>
    -->


    <?php $this->head() ?>
</head>
<body class='<?= Yii::$app->controller->getBodyClasses() ?>'>
<?php $this->beginBody() ?>

<?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>

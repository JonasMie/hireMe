<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Marco Karaula <marco.karaula@gmail.com>
 * @since 2.0
 */
class CustomAppAsset extends AssetBundle
{
    public $css = [
        'css/stylesheets/style.css',
        'http://fonts.googleapis.com/css?family=Roboto:400,300'
    ];
    public $js = [
        'js/footable.js',
        'js/Chart.min.js',
        'js/signup.js',
        'js/customScript.js'

    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];


}



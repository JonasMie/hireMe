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
        'js/customScript.js',
        'js/footable.js',
        'js/signup.js'

    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];


}



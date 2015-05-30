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
        'http://fonts.googleapis.com/css?family=PT+Sans'
    ];
    public $js = [
        'js/customScript.js',
    ];

}


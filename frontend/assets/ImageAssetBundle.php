<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 12.06.15
 * Time: 19:22
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ImageAssetBundle extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'js/jcrop/css/jquery.Jcrop.min.css',
    ];

    public $js = [
        'js/imageUpload.js',
        'js/jcrop/js/jquery.color.js',
        'js/jcrop/js/jquery.Jcrop.min.js',

    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
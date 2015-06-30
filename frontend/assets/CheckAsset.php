<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 15.06.15
 * Time: 18:50
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class CheckAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/checker.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
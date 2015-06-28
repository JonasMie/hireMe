<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 29.06.15
 * Time: 00:41
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class GiphyAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/loadGiphy.js',
    ];
     public $depends = [
        'yii\web\JqueryAsset',
    ];

}
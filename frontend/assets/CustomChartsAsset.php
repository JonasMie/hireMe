<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 18.06.15
 * Time: 13:12
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class CustomChartsAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/Chart.min.js',
        'js/customCharts.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
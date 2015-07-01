<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 25.06.15
 * Time: 00:28
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class DetailChartsAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/Chart.min.js',
        'js/detailCharts.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
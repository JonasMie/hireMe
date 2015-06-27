<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 27.06.15
 * Time: 02:08
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ScoreAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/scoreJS.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
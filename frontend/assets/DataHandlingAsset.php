<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 26.06.15
 * Time: 16:56
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class DataHandlingAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/dataHandler.js',
    ];

}
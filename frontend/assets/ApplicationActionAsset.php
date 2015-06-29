<?php
/**
 * Created by Simon Strobel.
 * Date: 29.06.15
 * Time: 12:06
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ApplicationActionAsset extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/applicationAction.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

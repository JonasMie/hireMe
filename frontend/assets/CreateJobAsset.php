<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 06.06.15
 * Time: 13:28
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class CreateJobAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/createJob.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
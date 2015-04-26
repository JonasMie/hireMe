<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 26.04.15
 * Time: 13:31
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class SignupAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/signup.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
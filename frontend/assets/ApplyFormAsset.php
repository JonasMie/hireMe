<?php
/**
 * Created by Simon Strobel.
 * User: simon
 * Date: 26.06.15
 * Time: 14:55
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ApplyFormAsset extends AssetBundle{

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/applyForm.js',
    ];
      public $depends = [
        'yii\web\JqueryAsset',
    ];
}
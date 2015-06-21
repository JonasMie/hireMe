<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 21.06.15
 * Time: 13:14
 * Project: hireMe
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class BulkAction extends AssetBundle{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/bulkAction.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}

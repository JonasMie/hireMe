<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class hmbtnController extends Controller
{

    // REQUEST FOR ACTION http://hireme.mi.hdm-stuttgart.de/index.php?r=cookie/getCookie
    public function actionAccessCookie() {
    $cookies = Yii::$app->request->cookies;

        if (($cookie = $cookies->get('_usr')) !== null) {
                $thisvalue = $cookie->value;
                //Yii::trace('Got the user id');
                return $thisvalue;
        }
    }

    public function actionGenerateBtn($company,$recruiter) {

        

    }
}

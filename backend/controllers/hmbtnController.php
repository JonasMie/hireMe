<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\models\ApplyBtn;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class hmbtnController extends Controller
{

    // Request: http://localhost/B20/backend/web/hmbtn/access-cookie
    public function actionAccessCookie() {
    $cookies = Yii::$app->request->cookies;

        if (($cookie = $cookies->get('_usr')) !== null) {
                $thisvalue = $cookie->value;
                //Yii::trace('Got the user id');
                return $thisvalue;
        }
    }

    // Request: http://localhost/B20/backend/web/hmbtn/generate-btn
    public function actionGenerateBtn() {

         $button = new ApplyBtn([
                        'company_id' => "1",
                        'recruiter_id' => "2"
                    ]);
        //return $button.toString();
        return "Klappt";

    }
}

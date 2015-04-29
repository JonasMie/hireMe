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

        $company_id = Yii::$app->company->getId();
        $recruiter_id = Yii::$app->user->getId();
        $button = new ApplyBtn([
                        'company_id' => $company_id,
                        'recruiter_id' => $recruiter_id
                    ]);
        
      
        $button->save();
        return '<iframe src="http://hireme.mi.hdm-stuttgart.de/" width="100" height="50" id="hireMeFrame" frameBorder="0" name="id_0001">
        </iframe>';
        //return "Klappt";

    }
}

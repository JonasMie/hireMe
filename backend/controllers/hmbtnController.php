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
   // public function getActionParams() {return array_merge($_Get, $_POST);}

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

        //$company_id = Yii::$app->company->getId();
        //$recruiter_id = Yii::$app->user->getId();
        //$jobAd_id = Yii::$app->jobAd->getId();
        $button = new ApplyBtn([
                        'company_id' => "1",
                        'recruiter_id' => "2"
                    ]);

      
        $button->save();

        Yii::$app->response->content = '<iframe src="http://localhost/B20/api/btnContainer.html" width="600" height="50" frameBorder="0" name="jobID">
        </iframe>';


    }

    public function actionBtnClicked() {

        $request = Yii::$app->request;
     //   return http_redirect("http:localhost/");
        $user = $request->get('user');   
        $jobAd_id = $request->get('jobAd_Id');
      Yii::$app->response->content = 'asdasd';

    }

}

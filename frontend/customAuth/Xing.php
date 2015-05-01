<?php
/**
 * Created by Jonas Miederer.
 * User: jonas
 * Date: 22.04.15
 * Time: 22:13
 * Project: Bewerbung
 */

namespace frontend\customAuth;


use yii\authclient\OAuth1;
use yii\authclient\signature;

class Xing extends OAuth1{

    public $authUrl = 'https://api.xing.com/v1/authorize';

    public $requestTokenUrl = 'https://api.xing.com/v1/request_token';

    public $accessTokenUrl = 'https://api.xing.com/v1/access_token';

    public $apiBaseUrl = 'https://api.xing.com/v1';

    protected function initUserAttributes()
    {
        return $this->api('users/me', 'GET');
    }

    protected function defaultName()
    {
        return 'xing';
    }

    protected function defaultTitle()
    {
        return 'Xing';
    }

    public function init()
    {
        parent::init();

    }

}
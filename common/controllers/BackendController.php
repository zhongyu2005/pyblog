<?php


namespace common\controllers;

use common\utils\CommonFunc;
use yii;

class BackendController extends \yii\web\Controller
{
    protected $needLogin = true;
    public $userInfo;

    public function init()
    {
        parent::init();

        $user=Yii::$app->getUser();
        $this->needLogin && $user->getIsGuest() && $this->goLogin();

        $userInfo=$user->getIdentity();
        if(empty($userInfo->id)){
            $this->goLogOut();
        }
        $this->userInfo=$userInfo->attributes();
        if (empty($this->userInfo)) {
            $this->goLogOut();
        }
    }

    public function beforeAction($action)
    {
        $result = parent::beforeAction($action);
        if ($this->loginRequired) {
            //todo
        }
        return $result;
    }

    public function goLogin()
    {
        $this->redirect('?r=auth/login');
        Yii::$app->end();
    }
    public function goLogOut()
    {
        $this->redirect('?r=auth/logout');
        Yii::$app->end();
    }

    public function get($name, $default = null)
    {
        return CommonFunc::get($name, $default);
    }

    public function post($name, $default)
    {
        return CommonFunc::post($name, $default);
    }

    public function isPost()
    {
        return CommonFunc::isPost();
    }

    public function isAjax()
    {
        return CommonFunc::isAjax();
    }

    public function getCookie($name)
    {
        return CommonFunc::getCookie($name);
    }

    public function setCookie($name, $val = null, $expire = 0)
    {
        return CommonFunc::setCookie($name, $val, $expire);
    }

    public function getSession($key)
    {
        return CommonFunc::getSession($key);
    }

    public function setSession($name, $val = null)
    {
        return CommonFunc::setSession($name, $val);
    }

    public function getConfig($key)
    {
        return CommonFunc::getConfig($key);
    }
}
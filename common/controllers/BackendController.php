<?php


namespace common\controllers;

use common\models\com\MenuModel;
use common\utils\CommonFunc;
use yii;

class BackendController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    protected $needLogin = true;
    public $userInfo;
    public $menu;

    public function init()
    {
        parent::init();
        if (!$this->needLogin) {
            return;
        }
        $user = Yii::$app->getUser();
        $this->needLogin && $user->getIsGuest() && $this->goLogin();
        $userInfo = $user->getIdentity();
        if (empty($userInfo->id)) {
            $this->goLogOut();
        }
        $this->userInfo = $userInfo->attributes;
        if (empty($this->userInfo)) {
            $this->goLogOut();
        }
    }

    public function beforeAction($action)
    {
        $result = parent::beforeAction($action);
        if (!$this->needLogin) {
            return $result;
        }
        $menu = MenuModel::getAll(['type' => MenuModel::TYPE_MENU]);
        $this->menu = MenuModel::menuTree($menu, 2);
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

    public function post($name, $default = null)
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

    public function ajaxReturn($data = null, $message = '', $code = '0')
    {
        CommonFunc::returnJson($data, $message, $code);
    }
}
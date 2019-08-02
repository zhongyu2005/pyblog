<?php

namespace backend\controllers;

use common\controllers\BackendController;
use Gregwar\Captcha\CaptchaBuilder;
use Yii;
use common\models\LoginForm;
use common\models\User;

/**
 * Site controller
 */
class AuthController extends BackendController
{

    public $layout = 'auth';
    protected $needLogin = false;

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->getUser()->getIsGuest()) {
            return $this->goHome();
        }
        $vars = [];
        if ($this->isPost()) {
            $vars = Yii::$app->request->post();
            if ($vars['captcha'] != $this->getSession('auth_captcha')) {
//                $vars['error'] = '验证码输入不正确';
            }
            if (!isset($vars['error'])) {
                $model = new LoginForm();
                if (!$model->load($vars)) {
                    $vars['error'] = '请填写账号和密码';
                } elseif ($model->login()) {
                    return $this->goBack();
                } else {
//                    var_dump($model->getErrors());
                    $vars['error'] = '账号或密码不正确';
                }
            }
        }
        return $this->render('login', compact('vars'));
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCaptcha()
    {
//        $phraseBuilder = new PhraseBuilder(6, '0123456789');

        $builder = new CaptchaBuilder(null);
        $builder->build();
        header('Content-type: image/jpeg');
        $this->setSession('auth_captcha', $builder->getPhrase());
        Yii::$app->getResponse()->send();
        $builder->output();
        Yii::$app->end();
    }


    /**
     * register
     */
    public function actionRegister()
    {
        //不开放.
        exit('register not found');
        $dateTime = new \DateTime(null, new \DateTimeZone('PRC'));
        $time = $dateTime->getTimestamp();
        $user = new User();
        $user->username = Yii::$app->request->get('name', 'test');
        $user->auth_key = '';
        $user->password_hash = '';
        $user->password_reset_token = '';
        $user->email = Yii::$app->request->get('name', 'test') . '@test_reg.com';
        $user->status = '10';
        $user->created_at = $user->updated_at = $time;
        $user->setPassword('123456');
        $user->generateAuthKey();
        $user->generatePasswordResetToken();
        $f = $user->save();
        if ($f) {
            exit('创建成功' . $user->id);
        }
        var_dump($f);
        exit('error');

    }
}

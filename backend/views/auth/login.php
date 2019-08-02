<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;

$this->title = 'Login';
?>
<style>
    .site-login {
        margin-top: 10%;
        min-width: 640px;
    }

    .form-captcha {
        padding: 10px 0;
    }
</style>
<script type="text/javascript">
    // 当前窗口不等于父窗口
    if (window.parent != window.self) {
        window.top.location.href = '?r=auth/login';
    }
</script>
<div class="site-login">
    <form class="form-signin" method="post" action="?r=auth/login">
        <h2 class="form-signin-heading">YeYelolo</h2>
        <br>
        <?php if (isset($vars['error'])): ?>
            <p class="text-danger error"><?=$vars['error']?></p>
        <?php endif; ?>

        <label for="username" class="sr-only">账号</label>
        <input type="text" id="username" maxlength="22" name="LoginForm[username]" class="form-control"
               value="<?= isset($vars['LoginForm']['username']) ? $vars['LoginForm']['username'] : '' ?>" placeholder="账号"
               required autofocus>&nbsp;
        <label for="password" class="sr-only">密码</label>
        <input type="password" id="password" name="LoginForm[password]" maxlength="12" class="form-control"
               placeholder="密码"
               required>

        <div class="form-captcha row">
            <div class="col-md-3 col-sm-3 col-xs-3">
                <input type="text" maxlength="5" name="captcha" class="form-control" required>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-3">
                <img style="height: 30px;" class="" title="点击刷新" src="?r=auth/captcha&1"
                     onclick="this.src='?r=auth/captcha&'+Math.random();"/>
            </div>
        </div>

        <div class="checkbox">
            <label>
                <input type="checkbox" name="LoginForm[rememberMe]" value="1"> 记住账号
            </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
    </form>
</div>

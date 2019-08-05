<?php

namespace backend\modules\setting\controllers;

use common\controllers\BackendController;
use common\models\com\RoleModel;
use common\models\com\UserModel;
use common\models\User;
use common\utils\CommonFunc;
use yii\helpers\ArrayHelper;

/**
 * Menu
 */
class UserController extends BackendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        if (!$this->isAjax()) {
            return $this->render('index');
        }
        $name = $this->post('name');
        $offset = $this->post('offset');
        $length = $this->post('length');

        $where = ['deleted' => 0, 'super_admin' => 0];
        $q = UserModel::find()->where($where)->asArray();
        if (!empty($name)) {
            $q->andWhere(['like', 'username', $name]);
        }
        $count = $q->count();
        if ($count) {
            $q->select(['id', 'username', 'auth_key', 'email', 'role_id', 'role_name', 'updated_at']);
            $q->offset($offset)->limit($length);
            $list = $q->all();
        }
        $ret = ['count' => $count, 'list' => $list];
        $this->ajaxReturn($ret);
    }

    public function actionCreate()
    {
        $roles = RoleModel::getRoles();
        if (!$this->isAjax()) {
            return $this->render('create', ['roles' => $roles]);
        }
        $roles = ArrayHelper::index($roles, 'id');
        $username = $this->post('username');
        $email = $this->post('email');
        $role_id = $this->post('role_id');

        $username = trim($username);
        $email = trim($email);
        $role_id = intval($role_id);


        if (empty($username) || mb_strlen($username, 'utf-8') > 30) {
            $this->ajaxReturn(null, "请填写合法的username", 1);
        }
        if (empty($email) || CommonFunc::valid($email, 'email') === false) {
            $this->ajaxReturn(null, "请填写合法的email", 1);
        }
        if (!isset($roles[$role_id])) {
            $this->ajaxReturn(null, "请选择合法的角色", 1);
        }
        $role_name = $roles[$role_id]['name'];

        $set = new User();
        $set->username = $username;
        $set->email = $email;
        $set->role_id = $role_id;
        $set->role_name = $role_name;
        $set->super_admin = 0;
        $set->status = 10;
        $set->created_at = $set->updated_at = time();
        $set->deleted = 0;
        $set->auth_key = '';
        $set->password_hash = '';
        $set->password_reset_token = '';
        $set->setPassword('123456');
        $set->generateAuthKey();
        $set->generatePasswordResetToken();
        $set->save();
        if ($set->id > 0) {
            $this->ajaxReturn(['id' => $set->id], "操作成功");
        }
        $this->ajaxReturn(null, "保存失败", 1);
    }

    public function actionUpdate()
    {
        $roles = RoleModel::getRoles();
        $id = $this->get('id');
        $set = User::findIdentity($id);
        if (!$this->isAjax()) {
            if (empty($set)) {
                $this->redirect('?r=setting/user/index');
            }
            $user = $set->attributes;
            return $this->render('update', ['roles' => $roles, 'user' => $user]);
        }
        if (empty($set)) {
            $this->ajaxReturn(null, "编辑内容不存在.", 1);
        }
        $roles = ArrayHelper::index($roles, 'id');
        $email = $this->post('email');
        $role_id = $this->post('role_id');
        $password = $this->post('password');

        $email = trim($email);
        $role_id = intval($role_id);


        if (empty($email) || CommonFunc::valid($email, 'email') === false) {
            $this->ajaxReturn(null, "请填写合法的email", 1);
        }
        if (!isset($roles[$role_id])) {
            $this->ajaxReturn(null, "请选择合法的角色", 1);
        }
        $role_name = $roles[$role_id]['name'];

        $set->email = $email;
        $set->role_id = $role_id;
        $set->role_name = $role_name;
        $set->updated_at = time();
        if (!empty($password)) {
            $set->setPassword($password);
            $set->generateAuthKey();
            $set->generatePasswordResetToken();
        }
        $set->save();
        if ($set->id > 0) {
            $this->ajaxReturn(['id' => $set->id], "操作成功");
        }
        $this->ajaxReturn(null, "保存失败", 1);
    }


    public function actionDel()
    {
        if (!$this->isAjax()) {
            return '';
        }
        $id = $this->get('id');
        $set = User::findIdentity($id);
        if (empty($set)) {
            $this->ajaxReturn(null, "编辑内容不存在.", 1);
        }
        $set->deleted = 1;
        $set->updated_at = time();
        $f = $set->save();
        if ($f) {
            $this->ajaxReturn(['id' => $set->id], "操作成功");
        }
        $this->ajaxReturn(null, "保存失败", 1);
    }

}

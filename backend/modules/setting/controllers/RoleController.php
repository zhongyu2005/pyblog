<?php

namespace backend\modules\setting\controllers;

use common\controllers\BackendController;
use common\models\com\MenuModel;
use common\models\com\RoleMenuModel;
use common\models\com\RoleModel;

/**
 * Menu
 */
class RoleController extends BackendController
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

        $where = ['deleted' => 0];
        $q = RoleModel::find()->where($where)->asArray();
        if (!empty($name)) {
            $q->andWhere(['like', 'name', $name]);
        }
        $count = $q->count();
        if ($count) {
            $q->select(['id', 'name', 'mark', 'updated_at']);
            $q->offset($offset)->limit($length);
            $list = $q->all();
        }
        $ret = ['count' => $count, 'list' => $list];
        $this->ajaxReturn($ret);
    }

    public function actionCreate()
    {
        if (!$this->isAjax()) {
            return $this->render('create');
        }
        $name = $this->post('name');
        $mark = $this->post('mark');

        $name = trim($name);
        $mark = trim($mark);

        if (empty($name) && mb_strlen($name, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的name", 1);
        }

        $set = new RoleModel();
        $set->name = $name;
        $set->mark = $mark;
        $set->created_at = $set->updated_at = time();
        $set->deleted = 0;
        $set->save();
        if ($set->id > 0) {
            $this->ajaxReturn(['id' => $set->id], "操作成功");
        }
        $this->ajaxReturn(null, "保存失败", 1);
    }

    public function actionUpdate()
    {
        $id = $this->get('id');
        $set = RoleModel::find()->where(['id' => $id, 'deleted' => 0])->limit(1)->one();
        if (!$this->isAjax()) {
            if (empty($set)) {
                $this->redirect('?r=setting/role/index');
            }
            $role = $set->attributes;
            return $this->render('update', ['role' => $role]);
        }
        if (empty($set)) {
            $this->ajaxReturn(null, "编辑的内容不存在", 1);
        }
        $name = $this->post('name');
        $mark = $this->post('mark');

        $name = trim($name);
        $mark = trim($mark);

        if (empty($name) && mb_strlen($name, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的name", 1);
        }

        $set->name = $name;
        $set->mark = $mark;
        $set->updated_at = time();
        $set->deleted = 0;
        $f = $set->save();
        if ($f) {
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
        $set = RoleModel::find()->where(['id' => $id, 'deleted' => 0])->limit(1)->one();
        if (empty($set)) {
            $this->ajaxReturn(null, "编辑的内容不存在", 1);
        }
        $set->deleted = 1;
        $set->updated_at = time();
        $set->deleted = 0;
        $f = $set->save();
        if ($f) {
            $this->ajaxReturn(['id' => $set->id], "操作成功");
        }
        $this->ajaxReturn(null, "保存失败", 1);
    }


    public function actionGrantAuth()
    {
        $id = $this->get('id');
        $set = RoleModel::find()->where(['id' => $id, 'deleted' => 0])->limit(1)->one();
        $where = ['deleted' => 0, 'type' => MenuModel::TYPE_MENU, 'status' => MenuModel::ST_ENABLE];
        $list = MenuModel::find()->where($where)->asArray()->all();
        if (!$this->isAjax()) {
            if (empty($set)) {
                $this->ajaxReturn(null, "编辑的内容不存在", 1);
            }
            $menus = MenuModel::menuTree($list);
            $userMenu = RoleMenuModel::find()->select(['menu_id'])
                ->where(["deleted" => 0, 'role_id' => $set->id])
                ->asArray()->column();
            return $this->render('grant-auth', ['menus' => $menus, 'userMenu' => $userMenu]);
        }
        if (empty($set)) {
            $this->ajaxReturn(null, "无对应角色信息", 1);
        }

        $menu_ids = $this->post('menu_ids');
        RoleMenuModel::saveRoleMenu($menu_ids, $set->id);
        $this->ajaxReturn(null, "操作成功", 1);
    }

}

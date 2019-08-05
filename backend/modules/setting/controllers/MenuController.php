<?php

namespace backend\modules\setting\controllers;

use common\controllers\BackendController;
use common\models\com\MenuModel;
use yii\helpers\ArrayHelper;

/**
 * Menu
 */
class MenuController extends BackendController
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
        $type = $this->post('type');
        $status = $this->post('status');

        $where = [
            'deleted' => 0
        ];
        if (isset($type) && in_array(intval($type), [1, 2])) {
            $where['type'] = intval($type);
        }
        if (isset($status) && in_array(intval($status), [0, 1])) {
            $where['status'] = intval($status);
        }
        $list = MenuModel::find()->where($where)->asArray()->all();
        $list = MenuModel::menuTree($list);
        $this->ajaxReturn($list);
    }

    public function actionCreate()
    {
        $parentMenu = MenuModel::getAll(['pid' => 0]);
        if (!$this->isAjax()) {
            $id = $this->get('id');
            $menu = [];
            if ($id > 0) {
                $menu = MenuModel::find()->where(['id' => $id, 'deleted' => 0])
                    ->asArray()->limit(1)->one();
            }
            return $this->render('create', compact('menu', 'parentMenu'));
        }
        $parentMenu = ArrayHelper::index($parentMenu, 'id');
        $pid = $this->post('pid');
        $name = $this->post('name');
        $route = $this->post('route');
        $type = $this->post('type');
        $status = $this->post('status');
        $mark = $this->post('mark');
        $sort = $this->post('sort');
        $style = $this->post('style');

        $pid = intval($pid);
        $type = intval($type);
        $status = intval($status);
        $sort = intval($sort);
        $mark = trim($mark);
        $style = trim($style);

        if ($pid > 0 && !isset($parentMenu[$pid])) {
            $this->ajaxReturn(null, "pid选择错误", 1);
        }
        if (empty($name) && mb_strlen($name, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的name", 1);
        }
        if (!empty($route) && mb_strlen($route, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的route", 1);
        }
        if (!in_array($type, [1, 2])) {
            $this->ajaxReturn(null, "请选择合法的type", 1);
        }
        if (!in_array($status, [1, 0])) {
            $this->ajaxReturn(null, "请选择合法的状态", 1);
        }
        if (!empty($mark) && mb_strlen($mark, 'utf-8') > 255) {
            $this->ajaxReturn(null, "请填写合法的备注", 1);
        }
        if (!empty($style) && mb_strlen($style, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的style", 1);
        }

        $set = new MenuModel();
        $set->pid = $pid;
        $set->name = $name;
        $set->route = $route;
        $set->type = $type;
        $set->mark = $mark;
        $set->sort = $sort;
        $set->style = $style;
        $set->status = $status;
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
        $parentMenu = MenuModel::getAll(['pid' => 0]);
        $id = $this->get('id');
        $set = MenuModel::find()->where(['id' => $id, 'deleted' => 0])->limit(1)->one();
        if (!$this->isAjax()) {
            if (empty($set)) {
                $this->redirect('?r=setting/menu/index');
            }
            $menu = $set->attributes;
            return $this->render('update', compact('menu', 'parentMenu'));
        }
        if (empty($set)) {
            $this->ajaxReturn(null, "编辑内容不存在.", 1);
        }
        $parentMenu = ArrayHelper::index($parentMenu, 'id');
        $pid = $this->post('pid');
        $name = $this->post('name');
        $route = $this->post('route');
        $type = $this->post('type');
        $status = $this->post('status');
        $mark = $this->post('mark');
        $sort = $this->post('sort');
        $style = $this->post('style');

        $pid = intval($pid);
        $type = intval($type);
        $status = intval($status);
        $sort = intval($sort);
        $mark = trim($mark);
        $style = trim($style);

        if ($pid > 0 && !isset($parentMenu[$pid])) {
            $this->ajaxReturn(null, "pid选择错误", 1);
        }
        if (empty($name) && mb_strlen($name, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的name", 1);
        }
        if (!empty($route) && mb_strlen($route, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的route", 1);
        }
        if (!in_array($type, [1, 2])) {
            $this->ajaxReturn(null, "请选择合法的type", 1);
        }
        if (!in_array($status, [1, 0])) {
            $this->ajaxReturn(null, "请选择合法的状态", 1);
        }
        if (!empty($mark) && mb_strlen($mark, 'utf-8') > 255) {
            $this->ajaxReturn(null, "请填写合法的备注", 1);
        }
        if (!empty($style) && mb_strlen($style, 'utf-8') > 50) {
            $this->ajaxReturn(null, "请填写合法的style", 1);
        }

        $set->pid = $pid;
        $set->name = $name;
        $set->route = $route;
        $set->type = $type;
        $set->mark = $mark;
        $set->sort = $sort;
        $set->style = $style;
        $set->status = $status;
        $set->updated_at = time();
        $set->deleted = 0;
        $f=$set->save();
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
        $set = MenuModel::find()->where(['id' => $id, 'deleted' => 0])->limit(1)->one();
        if(empty($set)){
            $this->ajaxReturn(null, "删除内容不存在.", 1);
        }
        $set->deleted=1;
        $set->updated_at=time();
        $f=$set->save();
        if ($f) {
            $this->ajaxReturn(['id' => $set->id], "操作成功");
        }
        $this->ajaxReturn(null, "保存失败", 1);
    }

}

<?php

namespace backend\modules\setting\controllers;

use common\controllers\BackendController;
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
        if(empty($set)){
            $this->ajaxReturn(null,"编辑的内容不存在",1);
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
        if(empty($set)){
            $this->ajaxReturn(null,"编辑的内容不存在",1);
        }
        $set->deleted=1;
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
        if (!$this->isAjax()) {
            return $this->render('grant-auth');
        }
        //@todo
    }

}

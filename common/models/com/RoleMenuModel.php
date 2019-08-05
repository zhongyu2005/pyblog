<?php

namespace common\models\com;

use yii\db\ActiveRecord;

class RoleMenuModel extends ActiveRecord
{

    public static function tableName()
    {
        return 'com_role_menu';
    }

    public function rules()
    {
        return [
            [[
                'role_id', 'menu_id', 'deleted'
            ], 'safe']
        ];
    }

    public static function saveRoleMenu($menuIds,$role_id){
        RoleMenuModel::updateAll(['deleted' => 1], ['role_id' => $role_id]);

        if (!empty($menuIds)) {
            foreach ($menuIds as $id) {
                $where = ['role_id' => $role_id, 'menu_id' => $id];
                $row = RoleMenuModel::find()->where($where)->one();
                if (empty($row)) {
                    $row = new RoleMenuModel();
                    $row->role_id = $role_id;
                    $row->menu_id = $id;
                }
                $row->deleted = 0;
                $row->save();
            }
        }
        return true;
    }
}
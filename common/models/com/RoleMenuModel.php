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
}
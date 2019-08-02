<?php

namespace common\models\com;

use yii\db\ActiveRecord;

class RoleModel extends ActiveRecord
{

    public static function tableName()
    {
        return 'com_role';
    }

    public function rules()
    {
        return [
            [[
                'name', 'mark',
                'created_at', 'updated_at', 'deleted'
            ], 'safe']
        ];
    }
}
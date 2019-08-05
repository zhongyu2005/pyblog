<?php

namespace common\models\com;

use yii\db\ActiveRecord;
use yii\db\Query;

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

    public static function getRoles()
    {
        $q = new Query();
        $q->from(self::tableName())->select(['id', 'name'])->where(['deleted' => 0]);
        return $q->all();
    }
}
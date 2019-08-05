<?php

namespace common\models\com;

use yii\db\ActiveRecord;

class UserModel extends ActiveRecord
{

    public static function tableName()
    {
        return 'com_user';
    }

    public function rules()
    {
        return [
            [[
                'username', 'password_hash', 'password_reset_token', 'email', 'auth_key', 'status',
                'super_admin', 'role_id','role_name',
                'created_at', 'updated_at', 'deleted'
            ], 'safe']
        ];
    }
}
<?php

namespace common\models\com;

use yii\db\ActiveRecord;
use yii\db\Query;

class MenuModel extends ActiveRecord
{
    const TYPE_MENU = 1;//普通
    const TYPE_AUTH = 2;//角色

    const ST_ENABLE = 0;//启用
    const ST_DISABLE = 1;//禁用

    public static function tableName()
    {
        return 'com_menu';
    }

    public function rules()
    {
        return [
            [[
                'pid', 'name', 'route', 'type', 'mark', 'sort', 'style', 'status',
                'created_at', 'updated_at', 'deleted'
            ], 'safe']
        ];
    }

    public static function getStatus($st)
    {
        if ($st == self::ST_ENABLE) {
            return '启用';
        } elseif ($st == self::ST_DISABLE) {
            return '禁用';
        }
    }


    public static function getAll($where)
    {
        $q = new Query();
        $q->from(self::tableName())->where($where)->orderBy(['pid' => SORT_ASC, 'sort' => SORT_ASC]);
        return $q->all();
    }

    public static function menuTree($list, $level = 3)
    {
        $root = [];
        $branch = [];
        $leaf = [];
        foreach ($list as $val) {
            $val['status_str'] = self::getStatus($val['status']);
            if ($val['pid'] == '0') {
                $root[$val['id']] = $val;
                continue;
            }
            if (isset($root[$val['pid']])) {
                $branch[$val['id']] = $val;
                continue;
            }
            if (isset($branch[$val['pid']])) {
                $leaf[$val['id']] = $val;
                continue;
            }
        }
        if($level=='3'){
            if(count($leaf)) {
                foreach ($leaf as $val) {
                    if (isset($branch[$val['pid']])) {
                        $branch[$val['pid']]['sub'][] = $val;
                    }
                }
            }
        }
        if(count($branch)) {
            foreach ($branch as $val) {
                if (isset($root[$val['pid']])) {
                    $root[$val['pid']]['sub'][] = $branch;
                }
            }
        }
        return $root;

    }
}
<?php

namespace backend\modules\setting\controllers;

use common\controllers\BackendController;
use common\models\com\MenuModel;

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
        //echo json
    }

    public function actionCreate()
    {
        if (!$this->isAjax()) {
            $id = $this->get('id');
            $menu = [];
            if ($id > 0) {
                $menu = MenuModel::find()->where(['id' => $id])->asArray()->limit(1)->one();
            }
            return $this->render('create', compact('menu'));
        }
        //echo json
    }

    public function actionUpdate()
    {
        if (!$this->isAjax()) {
            return $this->render('update');
        }
        //echo json
    }


    public function actionDel()
    {
        if (!$this->isAjax()) {
            return '';
        }
        //echo json
    }

}

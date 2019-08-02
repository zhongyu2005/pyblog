<?php

namespace backend\modules\setting\controllers;

use common\controllers\BackendController;
use common\models\com\MenuModel;

/**
 * Menu
 */
class UserController extends BackendController
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
            return $this->render('create');
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

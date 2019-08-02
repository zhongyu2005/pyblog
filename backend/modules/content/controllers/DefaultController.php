<?php

namespace backend\modules\content\controllers;

use common\controllers\BackendController;

/**
 * Default controller for the `content` module
 */
class DefaultController extends BackendController
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}

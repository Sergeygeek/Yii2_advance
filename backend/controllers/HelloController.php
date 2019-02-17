<?php
namespace backend\controllers;

use yii\web\Controller;


/**
 * Site controller
 */
class HelloController extends Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->renderContent('Hello from back');
    }
}

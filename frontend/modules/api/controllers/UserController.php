<?php

namespace frontend\modules\api\controllers;


use frontend\modules\api\models\User;
use yii\rest\ActiveController;

/**
 * Default controller for the `api` module
 */
class UserController extends ActiveController
{
    public $modelClass = User::class;
}

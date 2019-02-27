<?php

namespace frontend\modules\api\models;

/**
 * Class Task
 * @package frontend\modules\api\models
 *
 * @inheritdoc
 */

class User extends \common\models\User
{
    public function extraFields()
    {
        return [self::ACTIVED_TASKS];
    }

    public function fields()
    {
        return [
            'id',
            'name' => 'username'
        ];
    }


}

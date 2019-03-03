<?php

namespace frontend\modules\api\models;

/**
 * Class Task
 * @package frontend\modules\api\models
 *
 * @inheritdoc
 *
 * @property Task[] $activedTasks
 */

class User extends \common\models\User
{
    const ACTIVED_TASKS = 'activedTasks';

    public function getActivedTasks()
    {
        return $this->hasMany(Task::className(), ['executor_id' => 'id']);
    }

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

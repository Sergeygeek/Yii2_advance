<?php

namespace frontend\modules\api\models;

/**
 * Class Project
 * @package frontend\modules\api\models
 * @inheritdoc
 * @property Task[] $tasks
 */

class Project extends \common\models\Project
{
    const RELATION_TASKS = 'tasks';

    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function($model){
                return mb_substr($model->description, 0, 50);
            },
            'active'
        ];
    }

    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['project_id' => 'id']);
    }

    public function extraFields()
    {
        return [self::RELATION_TASKS];
    }
}

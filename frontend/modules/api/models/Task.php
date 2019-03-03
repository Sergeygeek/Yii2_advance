<?php

namespace frontend\modules\api\models;

/**
 * Class Task
 * @package frontend\modules\api\models
 *
 * @inheritdoc
 *
 * @property Project $project
 */

class Task extends \common\models\Task
{
    const RELATION_PROJECT = 'project';

    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    public function extraFields()
    {
        return [self::RELATION_PROJECT];
    }

    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function($model){
                return mb_substr($model->description, 0, 50);
            },
        ];
    }
}

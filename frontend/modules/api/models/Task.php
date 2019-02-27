<?php

namespace frontend\modules\api\models;

/**
 * Class Task
 * @package frontend\modules\api\models
 *
 * @inheritdoc
 */

class Task extends \common\models\Task
{
    public function fields()
    {
        return [
            'id',
            'title',
            'description_short' => function($model){
                return substr($model->description, 0, 50);
            }
        ];
    }

    public function extraFields()
    {
        return [self::RELATION_PROJECT];
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 09.03.2019
 * Time: 19:11
 */

namespace common\services;

use common\models\Project;
use common\models\User;
use yii\base\Component;
use yii\base\Event;


class EmailService extends Component
{
    public function send($to, $subject, $views, $data)
    {
        \Yii::$app
            ->mailer
            ->compose($views, $data)
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}
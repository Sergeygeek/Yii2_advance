<?php
/**
 *
 */

namespace common\services;

use common\models\Project;
use common\models\User;
use yii\base\Component;
use yii\base\Event;


class NotificationService extends Component
{
    public function notifyAboutNewRole($user, $role, $project)
    {
        $views = ['html' => 'assignRoleToProject-html', 'text' => 'assignRoleToProject-text'];
        $data = ['user' => $user, 'project' => $project, 'role' => $role];
        \Yii::$app->emailService->send($user->email, 'New role '. $role, $views, $data);
    }
}
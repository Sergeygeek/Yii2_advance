<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'chat' => \common\modules\chat\Module::class
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'projectService' => [
            'class' => \common\services\ProjectService::class,
            'on '.\common\services\ProjectService::EVENT_ASSIGN_ROLE =>
                function(\common\services\AssignRoleEvent $e){
                    Yii::$app->notificationService->notifyAboutNewRole($e->user, $e->role, $e->project);
                }
        ],
        'emailService' => [
            'class' => \common\services\EmailService::class,
        ],
        'notificationService' => [
            'class' => \common\services\NotificationService::class,
        ]
    ],
];

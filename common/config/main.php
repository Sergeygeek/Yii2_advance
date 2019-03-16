<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'comment' => [
            'class' => 'yii2mod\comments\Module',
        ],
        'chat' => \common\modules\chat\Module::class
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.comments' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/comments/messages',
                ],
            ],
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
        ],
        'taskService' => [
            'class' => common\services\TaskService::class
        ],
    ],
];

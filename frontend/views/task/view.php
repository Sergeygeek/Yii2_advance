<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Tasks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="task-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'project.title',
            'title',
            'description:ntext',
            'project_id',
            'executor_id',
            'started_at:datetime',
            'completed_at:datetime',
            'creator_id',
            'updater_id',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {update} {delete} {take}',
                'buttons' => [
                        'take' => function ($url, \common\models\Task $model, $key) {
                            $icon = \yii\bootstrap\Html::icon('hand-right');
                            return Html::a($icon, ['task/take', 'id' => $model->id], ['data' => [
                                'confirm' => 'Берете задачу?',
                                'method' => 'post'
                            ],]);
                        },
                ],
                'visibleButtons' => [
                    'update' => function(\common\models\Task $model, $key, $index) {
                        return Yii::$app->projectService->hasRole($model->project, Yii::$app->user->identity,
                            \common\models\ProjectUser::ROLE_MANAGER);
                    },
                    'delete' => function(\common\models\Task $model, $key, $index) {
                        return Yii::$app->projectService->hasRole($model->project, Yii::$app->user->identity,
                            \common\models\ProjectUser::ROLE_MANAGER);
                    },
                    'take' => function(\common\models\Task $model, $key, $index) {
                        return Yii::$app->projectService->hasRole($model->project, Yii::$app->user->identity,
                            \common\models\ProjectUser::ROLE_DEVELOPER);
                    }

                ]
            ]
        ],
    ]) ?>
    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>
</div>

<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ProjectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Projects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="project-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'title',
                'content' => function (\common\models\Project $model) {
                    return Html::a($model->title, ['view', 'id' => $model->id]);
                },
                'format' => 'html'
            ],
            [
                'attribute' => \common\models\Project::RELATION_PROJECT_USERS . '.role',
                'content' => function (\common\models\Project $model) {
                    return join(',', Yii::$app->projectService->getRoles($model, Yii::$app->user->identity));
                },
                'format' => 'html'
                //Yii::$app->projectService->getRolles($model, Yii::$app->user->identity)
            ],
            [
                'attribute' => 'active',
                'filter' => \common\models\Project::STATUSES_LABELS,
                'content' => function (\common\models\Project $model) {
                    return \common\models\Project::STATUSES_LABELS[$model->active];
                },
                'format' => 'html'
            ],
            'description:ntext',
            //'creator_id',
            //'updater_id',
            //'created_at',
            //'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>

<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Project */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Projects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="project-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'title',
            'description:ntext',
            [
                'attribute' => 'active',
                'value' => \common\models\Project::STATUSES_LABELS[$model->active],
            ],
            [
                'attribute' => 'creator_id',
                'content' => $model->creator_id,
            ],
            [
                'attribute' => 'updater_id',
                'content' => $model->updater_id,
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>
    <?php echo \yii2mod\comments\widgets\Comment::widget([
        'model' => $model,
    ]); ?>
</div>

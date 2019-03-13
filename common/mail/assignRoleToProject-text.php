<?php
/**
 * @var $this \yii\web\View
 * @var $user \common\models\User
 * @var $project \common\models\Project
 * @var $role string
 */

?>

Привет <?= \yii\helpers\Html::encode($user->username)?>,
В проекте <?= $project->title?> тебе назначена роль <?= $role ?>

<h3>Отправить сообщение</h3>

<input type="text" id="chat-field">
<?php
    $icon = \yii\bootstrap\Html::icon('send');
    echo \yii\bootstrap\Html::a($icon, '#', ['id' => 'send']);
?>
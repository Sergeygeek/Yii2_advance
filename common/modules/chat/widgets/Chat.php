<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 22.02.2019
 * Time: 18:23
 */
namespace common\modules\chat\widgets;

use common\modules\chat\widgets\assets\ChatAsset;

class Chat extends \yii\bootstrap\Widget
{
    public $port = 8081;
    public $userName;

    public function init()
    {
        ChatAsset::register($this->view);
    }

    public function run()
    {
        $this->view->registerJsVar('wsPort', $this->port);
        $this->view->registerJsVar('user', $this->userName);
        return $this->render('chat');
    }
}
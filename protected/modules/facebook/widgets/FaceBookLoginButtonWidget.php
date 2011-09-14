<?php
Yii::import('application.modules.facebook.widgets.FaceBookWidget');

class FaceBookLoginButtonWidget extends FaceBookWidget
{
    public $text = 'Войти через FaceBook';

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();

        echo "<fb:login-button>{$this->text}</fb:login-button>";
    }
}

?>
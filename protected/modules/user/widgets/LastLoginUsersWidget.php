<?php
/**
 * Виджет для вывода последних активных пользователей
 */
class LastLoginUsersWidget extends yupe\widgets\YWidget
{
    public $view       = 'lastloginuserswidget';
    public $avatarSize = 25; // pixels (square, height==width)

    public function run()
    {
        $models = User::model()->active()->findAll(array(
            'limit' => $this->limit,
            'order' => 'last_visit DESC',
        ));
        $this->render($this->view, array('models' => $models));
    }
}

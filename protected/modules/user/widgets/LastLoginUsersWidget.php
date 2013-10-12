<?php
/**
 * Виджет для вывода последних активных пользователей
 */
class LastLoginUsersWidget extends YWidget
{
    public $view = 'lastloginuserswidget';

    public function run()
    {
        $models = User::model()->active()->findAll(array(
            'limit' => $this->limit,
            'order' => 'last_visit DESC',
        ));
        $this->render($this->view, array('models' => $models));
    }
}

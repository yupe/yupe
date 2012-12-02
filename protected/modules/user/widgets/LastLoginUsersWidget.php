<?php
/**
 * Виджет для вывода последних активных пользователей
 */
class LastLoginUsersWidget extends YWidget
{
    public function run()
    {
        $models = User::model()->active()->findAll(array(
            'limit' => $this->limit,
            'order' => 'last_visit DESC',
        ));
        $this->render('lastloginuserswidget', array('models' => $models));
    }
}

<?php

/**
 * Виджет для вывода последних активных пользователей
 */
class LastLoginUsersWidget extends yupe\widgets\YWidget
{
    public $view = 'lastloginuserswidget';
    public $avatarSize = 25; // pixels (square, height==width)

    public function run()
    {
        $models = User::model()->active()->findAll(
            [
                'limit' => $this->limit,
                'order' => 'visit_time DESC',
            ]
        );
        $this->render($this->view, ['models' => $models]);
    }
}

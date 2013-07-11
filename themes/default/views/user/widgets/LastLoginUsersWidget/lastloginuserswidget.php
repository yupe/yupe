<?php
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => 'Пользователи',
            'headerIcon' => 'icon-user',
            'content' => $this->render('_users', array('models' => $models), true),
        )
    );
}








<?php
Yii::import('application.modules.user.UserModule');
if (isset($models) && !empty($models)) {
    $this->widget(
        'bootstrap.widgets.TbBox',
        array(
            'title' => Yii::t('UserModule.user','Users'),
            'headerIcon' => 'icon-user',
            'content' => $this->render('_users', array('models' => $models), true),
        )
    );
}








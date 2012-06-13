<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 13.06.12
 * Time: 11:34
 * To change this template use File | Settings | File Templates.
 */
class LastLoginUsersWidget extends YWidget
{
    public function run()
    {
        $models = User::model()->active()->findAll(array(
            'limit' => $this->limit,
            'order' => 'last_visit DESC'
        ));

        $this->render('lastloginuserswidget',array('models' => $models));
    }
}

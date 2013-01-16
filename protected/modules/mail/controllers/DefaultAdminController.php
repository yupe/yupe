<?php

class DefaultAdminController extends YBackController
{
    /**
     * Почтовые сообщения.
     */
    public function actionIndex()
    {
        $model = new MailEvent('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['MailEvent']))
            $model->attributes = $_GET['MailEvent'];
        $this->render('index', array('model' => $model));
    }
}
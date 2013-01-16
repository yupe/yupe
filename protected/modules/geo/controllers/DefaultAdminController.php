<?php
class DefaultAdminController extends YBackController
{
    public function actionIndex()
    {
        $this->render('index');
    }
}
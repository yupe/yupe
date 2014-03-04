<?php

class ShopBackendController extends yupe\components\controllers\BackController
{
    public function actionIndex()
    {
        $this->render('index');
    }
}
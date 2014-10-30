<?php

class StoreBackendController extends yupe\components\controllers\BackController
{
    public function actionIndex()
    {
        $this->render('index', ['storeModule' => $this->module]);
    }
}

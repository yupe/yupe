<?php

class StoreBackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index']],
            ['deny'],
        ];
    }

    public function actionIndex()
    {
        $this->render('index', ['storeModule' => $this->module]);
    }



}

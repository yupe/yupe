<?php

namespace application\modules\update\controllers;

use Yii;
use yupe\components\controllers\BackController;

class UpdateBackendController extends BackController
{
    public function actionIndex()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            $updates = Yii::app()->updateManager->getModulesUpdateList(
                Yii::app()->moduleManager->getModules()
            );

            Yii::app()->ajax->success(
                $this->renderPartial(
                    '_modules',
                    array(
                        'result' => $updates['result'],
                        'modules' => $updates['modules'],
                        'total' => $updates['total']
                    ),
                    true
                )
            );
        }

        $this->render('index');
    }
} 

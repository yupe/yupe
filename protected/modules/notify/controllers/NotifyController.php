<?php

class NotifyController extends \yupe\components\controllers\FrontController
{
    public function filters()
    {
        return [
            ['yupe\filters\YFrontAccessControl']
        ];
    }

    public function actionSettings()
    {
        $profile = Yii::app()->getUser()->getProfile();

        $model = NotifySettings::model()->getForUser($profile->id);

        if (null === $model) {
            $model = new NotifySettings();
            $model->create($profile->id);

            if (null === $model) {
                throw new CHttpException(404);
            }
        }

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['NotifySettings'])) {

            $model->setAttributes(Yii::app()->getRequest()->getPost('NotifySettings'));

            if ($model->save()) {

                Yii::app()->getUser()->setFlash(\yupe\widgets\YFlashMessages::SUCCESS_MESSAGE, Yii::t('NotifyModule.notify', 'Settings changed!'));

                $this->redirect(['/notify/notify/settings']);
            }
        }

        $this->render('settings', ['model' => $model]);
    }
} 

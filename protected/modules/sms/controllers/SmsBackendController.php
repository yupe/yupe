<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class SmsBackendController extends yupe\components\controllers\BackController
{

    /**
     * Управление сообщениями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Sms();

        $model->unsetAttributes();  // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Sms', []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Sms;

        if (Yii::app()->getRequest()->getParam('to'))
            $model->to = Yii::app()->getRequest()->getParam('to');

        if (($data = Yii::app()->getRequest()->getPost('Sms')) !== null) {
            $model->setAttributes($data);

            if ($model->save()) {

                $result=Yii::app()->smsru->sms_send($model->to,$model->text,$this->module->sender);

                if ($result['code']=="100") {
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('SmsModule.sms', 'Sms was sent!').' Current balance: '.$result['balance']
                    );
                } else {
                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                        Yii::t('SmsModule.sms', 'Sms not sent!').' Error code:'.$result['code'].' '.$result['description']
                    );
                }

                $this->redirect(
                    (array) Yii::app()->getRequest()->getPost(
                        'submit-type', ['create']
                    )
                );

            }
        }

        $this->render('create', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id - integer идентификатор нужной модели
     *
     * @return void
     *
     * @throws CHttpExcetption
     */
    public function loadModel($id)
    {
        if (($model = Sms::model()->findByPk((int) $id)) === null) {
            throw new CHttpException(
                404,
                Yii::t('SmsModule.sms', 'Requested page was not found.')
            );
        }
        return $model;
    }

}

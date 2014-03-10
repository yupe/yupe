<?php

/**
 * ContactController контроллер публичной части для формы контактов и раздела faq
 *
 * @category YupeController
 * @package  yupe.modules.feedback.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/

use yupe\widgets\YFlashMessages;

class ContactController extends yupe\components\controllers\FrontController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'yupe\components\actions\YCaptchaAction',
                'backColor' => 0xFFFFFF,
                'testLimit' => 1
            )
        );
    }

    public function actionIndex()
    {
        $form = new FeedBackForm;

        // если пользователь авторизован - подставить его данные
        if (Yii::app()->user->isAuthenticated()) {
            $form->email = Yii::app()->user->getState('email');
            $form->name = Yii::app()->user->getState('nick_name');
        }

        // проверить не передан ли тип и присвоить его аттрибуту модели
        $form->type = (int)Yii::app()->getRequest()->getParam('type', FeedBack::TYPE_DEFAULT);

        $module = Yii::app()->getModule('feedback');

        if (Yii::app()->getRequest()->getIsPostRequest() && !empty($_POST['FeedBackForm'])) {

            $form->setAttributes(Yii::app()->getRequest()->getPost('FeedBackForm'));

            if ($form->validate()) {

                // обработка запроса
                $backEnd = array_unique($module->backEnd);

                $success = true;

                if (is_array($backEnd)) {

                    foreach ($backEnd as $storage) {

                        $sender = new $storage(Yii::app()->mail, $module);

                        if (!$sender->send($form)) {
                            $success = false;
                        }
                    }
                }

                if ($success) {

                    if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                        Yii::app()->ajax->success(Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!'));
                    }

                    Yii::app()->getUser()->setFlash(
                        YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!')
                    );

                    $this->redirect(
                        $module->successPage ? array($module->successPage) : array('/feedback/contact/index/')
                    );
                }

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->ajax->failure(Yii::t('FeedbackModule.feedback', 'It is not possible to send message!'));
                }

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('FeedbackModule.feedback', 'It is not possible to send message!')
                );

            } else {

                if (Yii::app()->getRequest()->getIsAjaxRequest()) {
                    Yii::app()->ajax->rawText(CActiveForm::validate($form));
                }
            }
        }

        $this->render('index', array('model' => $form, 'module' => $module));
    }


    // отобразить сообщения   с признаком is_faq
    // @TODO CActiveDataProvider перенести в модуль
    public function actionFaq()
    {
        $dataProvider = new CActiveDataProvider('FeedBack', array(
            'criteria' => array(
                'condition' => 'is_faq = :is_faq AND (status = :sended OR status = :finished)',
                'params' => array(
                    ':is_faq' => FeedBack::IS_FAQ,
                    ':sended' => FeedBack::STATUS_ANSWER_SENDED,
                    ':finished' => FeedBack::STATUS_FINISHED,
                ),
                'order' => 'id DESC',
            )
        ));

        $this->render('faq', array('dataProvider' => $dataProvider));
    }

    public function actionFaqView($id)
    {
        $id = (int)$id;

        if (!$id) {
            throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Page was not found!'));
        }

        $model = FeedBack::model()->answered()->faq()->findByPk($id);

        if (null === $model) {
            throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Page was not found!'));
        }

        $this->render('faqView', array('model' => $model));
    }
}
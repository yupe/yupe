<?php
class ContactController extends yupe\components\controllers\FrontController
{
    public function actions()
    {
        return array('captcha' => array(
            'class'     => 'application.modules.yupe.components.actions.YCaptchaAction',
            'backColor' => 0xFFFFFF,
            'testLimit' => 1
        ));
    }

    public function actionIndex()
    {
        $form = new FeedBackForm;

        // если пользователь авторизован - подставить его данные
        if (Yii::app()->user->isAuthenticated())
        {
            $form->email = Yii::app()->user->getState('email');
            $form->name  = Yii::app()->user->getState('nick_name');
        }

        // проверить не передан ли тип и присвоить его аттрибуту модели
        $form->type = (int) Yii::app()->request->getParam('type', FeedBack::TYPE_DEFAULT);

        $module = Yii::app()->getModule('feedback');

        if (Yii::app()->request->isPostRequest && !empty($_POST['FeedBackForm']))
        {
            $form->setAttributes($_POST['FeedBackForm']);

            if ($form->validate())
            {
                // обработка запроса
                $backEnd = array_unique($module->backEnd);

                if (is_array($backEnd) && count($backEnd))
                {
                    // запись в базу
                    if (in_array('db', $backEnd))
                    {
                        unset($backEnd['db']);

                        $feedback = new FeedBack;

                        $feedback->setAttributes(array(
                            'name'  => $form->name,
                            'email' => $form->email,
                            'theme' => $form->theme,
                            'text'  => $form->text,
                            'phone' => $form->phone,
                            'type'  => $form->type,
                        ));

                        if ($feedback->save())
                        {
                            Yii::log(
                                Yii::t('FeedbackModule.feedback', 'Feedback was inserted in DB'),
                                CLogger::LEVEL_INFO,
                                FeedbackModule::$logCategory
                            );

                            if ($module->sendConfirmation && !count($backEnd))
                               $this->feedbackConfirmationEmail($feedback);

                            Yii::app()->user->setFlash(
                                YFlashMessages::SUCCESS_MESSAGE,
                                Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!')
                            );


                            if (!count($backEnd))
                            {
                                if (Yii::app()->request->isAjaxRequest)
                                    Yii::app()->ajax->success(Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!'));
                                $this->redirect($module->successPage ? array($module->successPage) : array('/feedback/faq'));
                            }
                        }
                        else
                        {
                            $form->addErrors($feedback->getErrors());

                            Yii::log(
                                Yii::t('FeedbackModule.feedback', 'Error when trying to record feedback in DB'),
                                CLogger::LEVEL_ERROR,
                                FeedbackModule::$logCategory
                            );
                            Yii::app()->user->setFlash(
                                YFlashMessages::ERROR_MESSAGE,
                                Yii::t('FeedbackModule.feedback', 'There is an error when trying to send message! Please try later!')
                            );
                            $this->render('index', array('model' => $form, 'module' => $module));
                        }
                    }

                    // отправка на почту
                    if (in_array('email', $backEnd) && count(explode(',', $module->emails)))
                    {
                        $emailBody = $this->renderPartial('feedbackEmail', array('model' => $feedback), true);

                        foreach (explode(',', $module->emails) as $mail)
                            Yii::app()->mail->send($feedback->email, $mail, $form->theme, $emailBody);

                        if ($module->sendConfirmation)
                            $this->feedbackConfirmationEmail($feedback);

                        Yii::log(
                            Yii::t('FeedbackModule.feedback', 'Feedback was send on e-mail'),
                            CLogger::LEVEL_INFO,
                            FeedbackModule::$logCategory
                        );
                        Yii::app()->user->setFlash(
                            YFlashMessages::SUCCESS_MESSAGE,
                            Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!')
                        );

                        if (Yii::app()->request->isAjaxRequest)
                            Yii::app()->ajax->success(Yii::t('FeedbackModule.feedback', 'Your message sent! Thanks!'));
                        $this->redirect($module->successPage ? array($module->successPage) : array('/feedback/faq'));
                    }
                }

                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('FeedbackModule.feedback', 'It is not possible to send message!')
                );

                if (Yii::app()->request->isAjaxRequest)
                    Yii::app()->ajax->failure(Yii::t('FeedbackModule.feedback', 'It is not possible to send message!'));

                $this->redirect(array('/feedback/index/'));
            }
            else
            {
                if (Yii::app()->request->isAjaxRequest)
                    Yii::app()->ajax->failure(Yii::t('FeedbackModule.feedback', 'Please check e-mail and fill the form correct.'));
            }
        }
        $this->render('index', array('model' => $form, 'module' => $module));
    }

     /**
     * Отправление потдтверждения пользователю о том, что его сообщение получено.
     * @param FeedBack $model
     * @return bool $result
     */
    private function feedbackConfirmationEmail(FeedBack $model)
    {
        $emailBody = $this->renderPartial('feedbackConfirmationEmail', array('model' => $model), true);
        $result = Yii::app()->mail->send(
            Yii::app()->getModule('feedback')->notifyEmailFrom,
            $model->email,
            Yii::t('FeedbackModule.feedback', 'Your proposition on site "{site}" was received', array('{site}' => Yii::app()->name)),
            $emailBody
        );

        if ($result)
            Yii::log(
                Yii::t('FeedbackModule.feedback', 'Feedback: Notification for user was sent to email successfully'),
                CLogger::LEVEL_INFO,
                FeedbackModule::$logCategory
            );
        else
            Yii::log(
                Yii::t('FeedbackModule.feedback', 'Feedback: can\'t send message'),
                CLogger::LEVEL_INFO,
                FeedbackModule::$logCategory
            );
        return $result;
    }

    // отобразить сообщения   с признаком is_faq
    // @TODO CActiveDataProvider перенести в модуль
    public function actionFaq()
    {
        $dataProvider = new CActiveDataProvider('FeedBack', array('criteria'  => array(
            'condition' => 'is_faq = :is_faq AND (status = :sended OR status = :finished)',
            'params'    => array(
                ':is_faq'   => FeedBack::IS_FAQ,
                ':sended'   => FeedBack::STATUS_ANSWER_SENDED,
                ':finished' => FeedBack::STATUS_FINISHED,
            ),
            'order'     => 'id DESC',
        )));
        $this->render('faq', array('dataProvider' => $dataProvider));
    }

    public function actionFaqView($id)
    {
        $id = (int) $id;
        if (!$id)
            throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Page was not found!'));

        $model = FeedBack::model()->answered()->faq()->findByPk($id);
        if (!$model)
            throw new CHttpException(404, Yii::t('FeedbackModule.feedback', 'Page was not found!'));
        $this->render('faqView', array('model' => $model));
    }
}
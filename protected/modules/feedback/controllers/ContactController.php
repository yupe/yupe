<?php
class ContactController extends YFrontController
{
    public function actions()
    {
        return array(
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            )
        );
    }

    public function actionIndex()
    {
        $form = new FeedBackForm;
        // если пользователь авторизован - подставить его данные 
        if(Yii::app()->user->isAuthenticated())
        {
            $form->email = Yii::app()->user->getState('email');

            $form->name = Yii::app()->user->getState('nick_name');
        }

        // проверить не передан ли тип и присвоить его аттрибуту модели
        $form->type = (int)Yii::app()->request->getParam('type',FeedBack::TYPE_DEFAULT);

        if (Yii::app()->request->isPostRequest && !empty($_POST['FeedBackForm']))
        {
            $form->setAttributes($_POST['FeedBackForm']);

            $module = Yii::app()->getModule('feedback');

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
                                                      'name' => $form->name,
                                                      'email' => $form->email,
                                                      'theme' => $form->theme,
                                                      'text' => $form->text,
                                                      'type' => $form->type
                                                 ));

                        if ($feedback->save())
                        {
                            Yii::log(Yii::t('feedback', 'Обращение пользователя добавлено в базу!'), CLogger::LEVEL_INFO, FeedbackModule::$logCategory);

                            if ($module->sendConfirmation && !count($backEnd))                             
                               $this->feedbackConfirmationEmail($feedback);                            
                            
                            Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('feedback', 'Ваше сообщение отправлено! Спасибо!'));
                            
                            if(!count($backEnd))
                                $this->redirect($module->successPage ? array($module->successPage) : array('/feedback/contact'));
                        }
                        else
                        {
                            $form->addErrors($feedback->getErrors());
                            Yii::log(Yii::t('feedback', 'Ошибка при добавлении обращения пользователя в базу!'), CLogger::LEVEL_ERROR, FeedbackModule::$logCategory);
                            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('feedback', 'При отправке сообщения произошла ошибка! Повторите попытку позже!'));
                            $this->render('index', array('model' => $form));                         
                        }
                    }
                    
                    // отправка на почту
                    if (in_array('email', $backEnd) && count(explode(',',$module->emails)))
                    {                        
                        $emailBody = $this->renderPartial('feedbackEmail', array('model' => $feedback), true);                       

                        foreach (explode(',',$module->emails) as $mail)                           
                            Yii::app()->mail->send($module->notifyEmailFrom, $mail, $form->theme, $emailBody);                                                

                        if ($module->sendConfirmation)                                                    
                            $this->feedbackConfirmationEmail($feedback);                                                
                        
                        Yii::log(Yii::t('feedback', 'Обращение пользователя отправлено на email!'), CLogger::LEVEL_INFO, FeedbackModule::$logCategory);
                        
                        Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('feedback', 'Ваше сообщение отправлено! Спасибо!'));

                        $this->redirect($module->successPage ? array($module->successPage) : array('/feedback/contact'));
                    }
                }

                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('feedback', 'Сообщение отправить невозможно!'));
                
                $this->redirect(array('/feedback/contact'));
            }
        }

        $this->render('index', array('model' => $form));
    }
    
     /**
     * Отправление потдтверждения пользователю о том, что его сообщение получено.
     * @param FeedBack $model 
     * @return bool $result
     */
    private function feedbackConfirmationEmail(FeedBack $model) 
    {        
        $emailBody = $this->renderPartial('feedbackConfirmationEmail', array('model' => $model), true);
        $result = Yii::app()->mail->send(Yii::app()->getModule('feedback')->notifyEmailFrom, $model->email, Yii::t('feedback', 'Ваше обращение на сайте "{site}" получено!',array('{site}' => Yii::app()->name)), $emailBody);
        if ($result)
            Yii::log(Yii::t('feedback', 'Обращение пользователя: подтверждение пользователю на email отослано.'), CLogger::LEVEL_INFO, FeedbackModule::$logCategory);
        else
            Yii::log(Yii::t('feedback', 'Обращение пользователя: не удалось отправить подтверждение.'), CLogger::LEVEL_INFO, FeedbackModule::$logCategory);
        return $result;
    }
}
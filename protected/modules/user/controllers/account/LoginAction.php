<?php 
class LoginAction extends CAction
{
    public function run()
    {
        $form = new LoginForm;

        if (Yii::app()->request->isPostRequest && !empty($_POST['LoginForm']))
        {
            $form->setAttributes($_POST['LoginForm']);

            if ($form->validate())
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('user', 'Вы успешно авторизовались!')
                );

                Yii::log(
                    Yii::t('user', 'Пользователь {email} авторизовался!', array('{email}' => $form->email)),
                    CLogger::LEVEL_INFO, UserModule::$logCategory
                );

                $module = Yii::app()->getModule('user');

                $redirect = (Yii::app()->user->isSuperUser() && $module->loginAdminSuccess)
                    ? array($module->loginAdminSuccess)
                    : array($module->loginSuccess);

                if (Yii::app()->user->isSuperUser())
                {
                    /* Получаем настройки по всем модулям для данного пользователя: */
                    $settings = Settings::model()->fetchUserModuleSettings(Yii::app()->user->id);
                    $sessionSettings = array();
                    /* Если передан не пустой массив, проходим по нему: */
                    if (!empty($settings) && is_array($settings))
                        foreach ($settings as $s)
                            /* Если есть атрибуты - продолжаем: */
                            if (isset($s->attributes))
                            {
                                /* Наполняем нашу сессию: */
                                if (!isset($sessionSettings[$s->module_id]))
                                    $sessionSettings[$s->module_id] = array();
                                $sessionSettings[$s->module_id][$s->param_name] = $s->param_value;
                            }
                    Yii::app()->session['modSettings'] = $sessionSettings;
                }

                $this->controller->redirect($redirect);
            }
            else
                Yii::log(
                    Yii::t('user', 'Ошибка авторизации! email => {email}, Password => {password}!', array(
                        '{email}' => $form->email,
                        '{password}' => $form->password
                    )),
                    CLogger::LEVEL_ERROR, UserModule::$logCategory
                );
        }
        $this->controller->render('login', array('model' => $form));
    }
}
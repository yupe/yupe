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

                /* Если админ - получаем настройки модулей: */
                if (Yii::app()->user->isSuperUser()) {
                    /* Получаем настройки по всем модулям для данного пользователя: */
                    $settings = Settings::model()->fetchUserModuleSettings(Yii::app()->user->id);
                    $sessionSettings = array();
                    /* Если передан не пустой массив, проходим по нему: */
                    if (!empty($settings) && is_array($settings)) {
                        foreach ($settings as $sets) {
                            /* Если есть атрибуты - продолжаем: */
                            if (isset($sets->attributes)) {
                                /* Наполняем нашу сессию: */
                                if (!isset($sessionSettings[$sets->module_id]))
                                    $sessionSettings[$sets->module_id] = array();
                                $sessionSettings[$sets->module_id][$sets->param_name] = $sets->param_value;
                            }
                        }
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
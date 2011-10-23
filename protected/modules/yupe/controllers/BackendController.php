<?php
class BackendController extends YBackController
{
    public function actionIndex()
    {
        $this->render('index', Yii::app()->yupe->getModules());
    }

    public function actionSettings()
    {
        $this->render('settings');
    }

    public function actionModulesettings($module)
    {
        $module = Yii::app()->getModule($module);

        if (!$module)
        {
            throw new CHttpException(404, Yii::t('yupe', 'Страница настроек данного модуля недоступна!'));
        }

        $elements = array();

        $editableParams = $module->getEditableParams();

        $moduleParamsLabels = $module->getParamsLabels();

        foreach ($module as $key => $value)
        {
            if (in_array($key, $editableParams) && !is_object($value) && !is_array($value))
            {
                $elements[$key] = array(
                    'type' => 'text',
                    'maxlength' => 200,
                    'label' => $moduleParamsLabels[$key],
                    'id' => $key,
                    'name' => $key,
                    'value' => $value
                );
            }
        }

        // сформировать боковое меню из ссылок на настройки модулей
        $modules = Yii::app()->yupe->getModules();

        $menu = array();

        foreach ($modules['modules'] as $oneModule)
        {
            if ($oneModule->getEditableParams())
            {
                array_push($menu, array('label' => $oneModule->getName(), 'url' => $this->createUrl('/yupe/backend/modulesettings/', array('module' => $oneModule->getId()))));
            }
        }

        $this->render('modulesettings', array('menu' => $menu, 'module' => $module, 'elements' => $elements));
    }


    public function actionSaveModulesettings()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $module_id = Yii::app()->request->getPost('module_id');

            if (!$module_id)
            {
                throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));
            }

            $module = Yii::app()->getModule($module_id);

            if (!$module)
            {
                throw new CHttpException(404, Yii::t('yupe', 'Модуль "{module}" не найден!', array('{module}' => $module_id)));
            }

            $editableParams = $module->getEditableParams();

            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                Settings::model()->deleteAll('module_id = :module_id', array(':module_id' => $module_id));

                foreach ($_POST as $key => $value)
                {
                    if (in_array($key, $editableParams))
                    {
                        $model = new Settings();

                        $model->setAttributes(array(
                                                   'module_id' => $module_id,
                                                   'param_name' => $key,
                                                   'param_value' => $value
                                              ));

                        if (!$model->save())
                        {
                            //@TODO  исправить вывод ошибок
                            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, print_r($model->getErrors(), true));

                            $this->redirect(array('/yupe/backend/modulesettings', 'module' => $module_id));
                        }
                    }
                }

                $transaction->commit();

                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('yupe', 'Настройки модуля "{module}" сохранены!', array('{module}' => $module->getName())));

                //@TODO сброс полностью - плохо =(
                Yii::app()->cache->flush();

                $this->redirect(array('/yupe/backend/modulesettings/', 'module' => $module_id));
            }
            catch (Exception $e)
            {
                $transaction->rollback();

                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, $e->getMEssage());

                $this->redirect(array('/yupe/backend/modulesettings', 'module' => $module_id));
            }
        }

        throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));
    }


    public function actionThemesettings()
    {
        if (Yii::app()->request->isPostRequest && isset($_POST['theme']))
        {
            $theme = Yii::app()->request->getPost('theme');

            $settings = Settings::model()->find('module_id = :module_id AND param_name = :param_name', array(':module_id' => Yii::app()->yupe->coreModuleId, ':param_name' => 'theme'));

            if (!is_null($settings))
            {
                $settings->param_value = $theme;

                if ($settings->save())
                {
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('yupe', 'Настройки сохранены!'));

                    //@TODO сброс полностью - плохо =(
                    Yii::app()->cache->flush();

                    $this->redirect(array('/yupe/backend/themesettings/'));
                }
            }
            else
            {
                $settings = new Settings();

                $settings->setAttributes(array(
                                              'module_id' => Yii::app()->yupe->coreModuleId,
                                              'param_name' => 'theme',
                                              'param_value' => $theme
                                         ));

                if ($settings->save())
                {
                    Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('yupe', 'Настройки сохранены!'));

                    //@TODO сброс полностью - плохо =(
                    Yii::app()->cache->flush();

                    $this->redirect(array('/yupe/backend/themesettings/'));
                }
            }

            Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('yupe', 'При сохранении произошла ошибка!'));

            $this->redirect(array('/yupe/backend/themesettings/'));
        }

        $themes = array();

        if ($handler = opendir(Yii::app()->themeManager->basePath))
        {
            $file = false;

            while (($file = readdir($handler)))
            {
                if ($file != '.' && $file != '..' && !is_file($file))
                {
                    $themes[$file] = $file;
                }
            }

            closedir($handler);
        }

        $theme = Yii::app()->theme ? Yii::app()->theme->name
            : Yii::t('yupe', 'Тема не используется');

        $this->render('themesettings', array('themes' => $themes, 'theme' => $theme));
    }
}
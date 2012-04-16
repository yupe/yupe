<?php
class BackendController extends YBackController
{
    public function actionIndex()
    {
        $this->render('index', Yii::app()->getModule('yupe')->getModules());
    }

    public function actionSettings()
    {
        $this->render('settings');
    }

    public function actionModulesettings($module)
    {
        $module = Yii::app()->getModule($module);

        if (!$module)
            throw new CHttpException(404, Yii::t('yupe', 'Страница настроек данного модуля недоступна!'));

        $elements = array();

        $editableParams = $module->getEditableParams();

        $moduleParamsLabels = $module->getParamsLabels();

        foreach ($module as $key => $value)
        {
            if(array_key_exists($key, $editableParams))
                $elements[$key] = CHtml::label($moduleParamsLabels[$key],$key).CHtml::dropDownList($key,$value,$editableParams[$key]);

            if(in_array($key, $editableParams))
                $elements[$key] = CHtml::label($moduleParamsLabels[$key],$key).CHtml::textField($key,$value,array('maxlength' => 200));
        }

        // сформировать боковое меню из ссылок на настройки модулей
        $modules = Yii::app()->getModule('yupe')->getModules();

        $this->menu = array();

        foreach ($modules['modules'] as $oneModule)
        {
            if ($oneModule->getEditableParams())
            {
                array_push($this->menu, array('label' => $oneModule->getName(), 'url' => $this->createUrl('/yupe/backend/modulesettings/', array('module' => $oneModule->getId()))));
            }
        }

        $this->render('modulesettings', array('module' => $module, 'elements' => $elements, 'moduleParamsLabels' => $moduleParamsLabels));
    }


    public function actionSaveModulesettings()
    {
        if (Yii::app()->request->isPostRequest)
        {
            $module_id = Yii::app()->request->getPost('module_id');

            if (!$module_id)
                throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

            $module = Yii::app()->getModule($module_id);

            if (!$module)
                throw new CHttpException(404, Yii::t('yupe', 'Модуль "{module}" не найден!', array('{module}' => $module_id)));

            $editableParams = $module->getEditableParams();

            $transaction = Yii::app()->db->beginTransaction();

            try
            {
                Settings::model()->deleteAll('module_id = :module_id', array(':module_id' => $module_id));

                foreach ($_POST as $key => $value)
                {
                    if (in_array($key, $editableParams) || array_key_exists($key,$editableParams))
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
        // Параметры, которые нам интересны
        $params   = array('theme','backendTheme');
        $moduleId = Yii::app()->getModule('yupe')->coreModuleId;

        $settings = Settings::model()->fetchModuleSettings($moduleId,$params);

        if (Yii::app()->request->isPostRequest)
        {
            $wasErrors=false;
            foreach ($params as $p)
            {
                    $pval  = Yii::app()->request->getPost($p);
                    // Если параметр уже был - обновим, иначе надо создать новый
                    if (isset($settings[$p]))
                    {
                        // Если действительно изменили настройку
                        if ($settings[$p]->param_value!=$pval)
                        {
                            $settings[$p]->param_value = $pval;

                            if (!$settings[$p]->save())
                                $wasErrors=true;
                        }
                    }
                    else
                    {
                        $settings[$p] = new Settings();

                        $settings[$p]->setAttributes(array(
                                                      'module_id'   => $moduleId,
                                                      'param_name'  => $p,
                                                      'param_value' => $pval
                                                 ));

                        if (!$settings[$p]->save())
                            $wasErrors=true;
                    }
            }
            if (!$wasErrors)
            {
                Yii::app()->user->setFlash(YFlashMessages::NOTICE_MESSAGE, Yii::t('yupe', 'Настройки сохранены!'));

                //@TODO сброс полностью - плохо =(
                Yii::app()->cache->flush();

                $this->redirect(array('/yupe/backend/themesettings/'));
            } else
            {
                Yii::app()->user->setFlash(YFlashMessages::ERROR_MESSAGE, Yii::t('yupe', 'При сохранении произошла ошибка!'));
                $this->redirect(array('/yupe/backend/themesettings/'));
            }
        }

        $backendThemes = array(""=>"Не использовать");
        $themes = array();

        if ($handler = opendir(Yii::app()->themeManager->basePath))
        {
            $file = false;

            while (($file = readdir($handler)))
            {
                if ($file != '.' && $file != '..' && !is_file($file))
                    if ("backend_"==substr($file,0,8))
                    {
                        $file=str_replace("backend_","",$file);
                        $backendThemes[$file]=$file;
                    }
                    else
                        $themes[$file] = $file;
            }

            closedir($handler);
        }

        $module = Yii::app()->getModule('yupe');
        $theme = isset($settings['theme']) ? $settings['theme']->param_value
            : Yii::t('yupe', 'Тема не используется');

        $backendTheme = isset($settings['backendTheme']) ? $settings['backendTheme']->param_value
            : ($module->backendTheme ? $module->backendTheme : Yii::t('yupe', 'Тема не используется'));

        $this->render('themesettings', array('themes' => $themes, 'theme' => $theme, 'backendThemes' => $backendThemes, 'backendTheme' => $backendTheme ));
    }
}
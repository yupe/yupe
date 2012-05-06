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
            if (array_key_exists($key, $editableParams))
                $elements[$key] = CHtml::label($moduleParamsLabels[$key], $key) . CHtml::dropDownList($key, $value, $editableParams[$key]);

            if (in_array($key, $editableParams))
            {
                $label = isset($moduleParamsLabels[$key]) ? $moduleParamsLabels[$key] : $key;

                $elements[$key] = CHtml::label($label, $key) . CHtml::textField($key, $value, array('maxlength' => 200));
            }
        }

        // сформировать боковое меню из ссылок на настройки модулей
        $modules = Yii::app()->getModule('yupe')->getModules();

        $this->menu = array();

        foreach ($modules['modules'] as $oneModule)
        {
            if ($oneModule->getEditableParams())
                array_push($this->menu, array('label' => $oneModule->getName(), 'url' => $this->createUrl('/yupe/backend/modulesettings/', array('module' => $oneModule->getId()))));
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
                    if (in_array($key, $editableParams) || array_key_exists($key, $editableParams))
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
            } catch (Exception $e)
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
        $params = array('theme', 'backendTheme');
        $module = Yii::app()->getModule('yupe');
        $moduleId = $module->coreModuleId;

        $settings = Settings::model()->fetchModuleSettings($moduleId, $params);

        if (Yii::app()->request->isPostRequest)
        {
            $wasErrors = false;
            foreach ($params as $p)
            {
                $pval = Yii::app()->request->getPost($p);
                // Если параметр уже был - обновим, иначе надо создать новый
                if (isset($settings[$p]))
                {
                    // Если действительно изменили настройку
                    if ($settings[$p]->param_value != $pval)
                    {
                        $settings[$p]->param_value = $pval;

                        if (!$settings[$p]->save())
                            $wasErrors = true;
                    }
                }
                else
                {
                    $settings[$p] = new Settings;

                    $settings[$p]->setAttributes(array(
                        'module_id' => $moduleId,
                        'param_name' => $p,
                        'param_value' => $pval
                    ));

                    if (!$settings[$p]->save())
                        $wasErrors = true;
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

        $themes = $module->getThemes();

        $backendThemes = $module->getThemes(true);

        $backendThemes[""] = Yii::t('yupe', '--стандартная тема--');

        $theme = isset($settings['theme']) ? $settings['theme']->param_value : Yii::t('yupe', 'Тема не используется');

        $backendTheme = isset($settings['backendTheme']) ? $settings['backendTheme']->param_value : ($module->backendTheme ? $module->backendTheme : Yii::t('yupe', 'Тема не используется'));

        $this->render('themesettings', array('themes' => $themes, 'theme' => $theme, 'backendThemes' => $backendThemes, 'backendTheme' => $backendTheme));
    }

    /**
     * Метод для загрузки файлов из редактора при создании контента
     *
     * @since 0.0.4
     *
     * Подробнее http://imperavi.com/redactor/docs/images/
     */
    public function actionAjaxFileUpload()
    {
        if (!empty($_FILES['file']['name']))
        {
            $uploadPath = Yii::getPathOfAlias(Yii::app()->getModule('yupe')->uploadPath) . '/' . date('dmY') . '/';

            if (!is_dir($uploadPath))
            {
                if (!@mkdir($uploadPath))
                    Yii::app()->ajax->rawText(Yii::t('yupe', 'Не удалось создать каталог "{dir}" для файлов!', array('{dir}' => $uploadPath)));
            }

            $image = CUploadedFile::getInstanceByName('file');

            if ($image)
            {
                //сгенерировать имя файла и сохранить его
                $newFileName = md5(time() . uniqid() . $image->name) . '.' . $image->extensionName;

                if (!$image->saveAs($uploadPath . $newFileName))
                    Yii::app()->ajax->rawText(Yii::t('yupe', 'При загрузке произошла ошибка!'));

                $webDir = substr($uploadPath, strpos($uploadPath, Yii::app()->baseUrl) + strlen(Yii::app()->baseUrl));

                Yii::app()->ajax->rawText(CHtml::image(Yii::app()->baseUrl . $webDir . DIRECTORY_SEPARATOR . $newFileName));
            }
        }

        Yii::app()->ajax->rawText(Yii::t('yupe', 'При загрузке произошла ошибка!'));
    }
}
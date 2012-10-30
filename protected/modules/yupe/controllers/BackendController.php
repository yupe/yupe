<?php

class BackendController extends YBackController
{
    public function actionIndex()
    {
        $this->render('index', $this->yupe->getModules());
    }

    public function actionSettings()
    {
        $this->render('settings', $this->yupe->getModules());
    }

    public function actionModulesettings($module)
    {
        if (!($module = Yii::app()->getModule($module)))
            throw new CHttpException(404, Yii::t('yupe', 'Страница настроек данного модуля недоступна!'));

        $elements = array();

        $editableParams     = $module->editableParams;
        $moduleParamsLabels = $module->paramsLabels;

        foreach ($module as $key => $value)
        {
            if (array_key_exists($key, $editableParams))
                $elements[$key] = CHtml::label($moduleParamsLabels[$key], $key) .
                                  CHtml::dropDownList($key, $value, $editableParams[$key], array('empty' => Yii::t('yupe', '--выберите--'), 'class' => 'span10'));

            else if (in_array($key, $editableParams))
                $elements[$key] = CHtml::label((isset($moduleParamsLabels[$key]) ? $moduleParamsLabels[$key] : $key), $key) .
                                  CHtml::textField($key, $value, array('maxlength' => 300, 'class' => 'span10'));
        }

        // сформировать боковое меню из ссылок на настройки модулей        
        $this->menu = $this->yupe->modules['modulesNavigation'][$this->yupe->category]['items']['settings']['items'];

        $this->render('modulesettings', array(
            'module'             => $module,
            'elements'           => $elements,
            'moduleParamsLabels' => $moduleParamsLabels,
        ));
    }

    public function actionSaveModulesettings()
    {
        if (Yii::app()->request->isPostRequest)
        {
            if (!($moduleId = Yii::app()->request->getPost('module_id')))
                throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));

            if (!($module = Yii::app()->getModule($moduleId)))
                throw new CHttpException(404, Yii::t('yupe', 'Модуль "{module}" не найден!', array('{module}' => $module_id)));

           if (!$this->saveParamsSetting($moduleId, $module->editableParamsKey))
           {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('yupe', 'Настройки модуля "{module}" сохранены!', array('{module}' => $module->getName())
                ));

                //@TODO исправить очистку кэша
                Yii::app()->cache->flush();
            }
            else
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('yupe', 'При сохранении произошла ошибка!')
                );

            $this->redirect(array('/yupe/backend/modulesettings', 'module' => $moduleId));
        }

        throw new CHttpException(404, Yii::t('yupe', 'Страница не найдена!'));
    }

    public function actionThemesettings()
    {
        if (Yii::app()->request->isPostRequest)
        {
            if (!$this->saveParamsSetting($this->yupe->coreModuleId, array('theme', 'backendTheme')))
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('yupe', 'Настройки тем сохранены!')
                );

                //@TODO сброс полностью - плохо =(
                Yii::app()->cache->flush();
            }
            else
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('yupe', 'При сохранении настроек произошла ошибка!')
                );

            $this->redirect(array('/yupe/backend/themesettings/'));
        }

        $theme = isset($settings['theme'])
            ? $settings['theme']->param_value
            : Yii::t('yupe', 'Тема не используется');
        $backendTheme = isset($settings['backendTheme'])
            ? $settings['backendTheme']->param_value
            : ($this->yupe->backendTheme ? $this->yupe->backendTheme : Yii::t('yupe', 'Тема не используется'));

        $this->render('themesettings', array(
            'themes'        => $this->yupe->getThemes(),
            'theme'         => $theme,
            'backendThemes' => $this->yupe->getThemes(true),
            'backendTheme'  => $backendTheme,
         ));
    }

    public function saveParamsSetting($moduleId, $params)
    {
        $settings = Settings::model()->fetchModuleSettings($moduleId, $params);

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
                        return true;
                }
            }
            else
            {
                $settings[$p] = new Settings;

                $settings[$p]->setAttributes(array(
                    'module_id'   => $moduleId,
                    'param_name'  => $p,
                    'param_value' => $pval,
                ));

                if (!$settings[$p]->save())
                    return true;
            }
        }
        return false;
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
            $rename     = (int) Yii::app()->request->getQuery('rename', 1);
            $webPath    = '/' . $this->yupe->uploadPath . '/' . date('dmY') . '/';
            $uploadPath = Yii::getPathOfAlias('webroot') . $webPath;

            if (!is_dir($uploadPath))
            {
                if (!@mkdir($uploadPath))
                    Yii::app()->ajax->rawText(Yii::t('yupe', 'Не удалось создать каталог "{dir}" для файлов!', array('{dir}' => $uploadPath)));
            }

            $image = CUploadedFile::getInstanceByName('file');

            if ($image)
            {
                //сгенерировать имя файла и сохранить его
                $newFileName = $rename ? md5(time() . uniqid() . $image->name) . '.' . $image->extensionName : $image->name;

                if (!$image->saveAs($uploadPath . $newFileName))
                    Yii::app()->ajax->rawText(Yii::t('yupe', 'При загрузке произошла ошибка!'));

                Yii::app()->ajax->rawText(CJSON::encode(array('filelink' => Yii::app()->baseUrl . $webPath . $newFileName)));
            }
        }
        Yii::app()->ajax->rawText(Yii::t('yupe', 'При загрузке произошла ошибка!'));
    }

    /**
     * Очистка кэша сайта
     *
     * @since 0.0.4
     *
     */
    public function actionCacheflush()
    {
        Yii::app()->cache->flush();
        Yii::app()->user->setFlash(
            YFlashMessages::NOTICE_MESSAGE,
            Yii::t('yupe', 'Кэш успешно сброшен!')
        );

        $referrer = Yii::app()->getRequest()->getUrlReferrer();
        $this->redirect($referrer !== null ? $referrer : array("/yupe/backend"));
    }

    /**
     * Страничка для отображения ссылок на ресурсы для получения помощи
     *
     * @since 0.0.4
     *
     */
    public function actionHelp()
    {
        $this->render('help');
    }
}
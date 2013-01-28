<?php

class BackendController extends YBackController
{
    public function actionIndex()
    {
        $this->render('index', $this->yupe->getModules(false, true));
    }

    public function actionSettings()
    {
        $this->render('settings', $this->yupe->getModules(false, true));
    }

    public function actionModulesettings($module)
    {
        if (!($module = Yii::app()->getModule($module)))
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница настроек данного модуля недоступна!'));

        $elements = array();

        $editableParams     = $module->editableParams;
        $moduleParamsLabels = $module->paramsLabels;

        foreach ($module as $key => $value)
        {
            if (array_key_exists($key, $editableParams))
                $elements[$key] = CHtml::label($moduleParamsLabels[$key], $key) .
                                  CHtml::dropDownList($key, $value, $editableParams[$key], array('empty' => Yii::t('YupeModule.yupe', '--выберите--'), 'class' => 'span10'));

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
                throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

            if (!($module = Yii::app()->getModule($moduleId)))
                throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Модуль "{module}" не найден!', array('{module}' => $moduleId)));

           if (!$this->saveParamsSetting($moduleId, $module->editableParamsKey))
           {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Настройки модуля "{module}" сохранены!', array('{module}' => $module->getName())
                ));

                //@TODO исправить очистку кэша
                Yii::app()->cache->flush();
            }
            else
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'При сохранении произошла ошибка!')
                );
            $this->redirect(array('/yupe/backend/modulesettings', 'module' => $moduleId));
        }
        throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));
    }

    public function actionThemesettings()
    {
        if (Yii::app()->request->isPostRequest)
        {
            if (!$this->saveParamsSetting($this->yupe->coreModuleId, array('theme', 'backendTheme')))
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Настройки тем сохранены!')
                );
                //@TODO сброс полностью - плохо =(
                Yii::app()->cache->flush();
            }
            else
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'При сохранении настроек произошла ошибка!')
                );
            $this->redirect(array('/yupe/backend/themesettings/'));
        }

        $settings = Settings::model()->fetchModuleSettings('yupe', array('theme', 'backendTheme'));
        $noThemeValue = Yii::t('YupeModule.yupe', 'Тема не используется');

        $theme = isset($settings['theme']) && $settings['theme']->param_value != ''
            ? $settings['theme']->param_value
            : $noThemeValue;
        $backendTheme = isset($settings['backendTheme']) && $settings['backendTheme']->param_value != ''
            ? $settings['backendTheme']->param_value
            : $noThemeValue;

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
     * Метод для включения и отключения модуля
     *
     * @since 0.5
     *
     */
    public function actionModuleChange($name, $status)
    {
        if (($module = Yii::app()->getModule($name)) == NULL)
            $module = $this->yupe->getCreateModule($name);

        // @TODO Временный хак, дающий возможность переустановки, после появления обновлению, будет закрыт
        if ($name == 'install')
            $status = ($status == 0) ? 1 : 0;
        try
        {
            ($status == 0) ? $module->deactivate : $module->activate;
            Yii::app()->user->setFlash(
                YFlashMessages::NOTICE_MESSAGE,
                Yii::t('YupeModule.yupe', 'Модуль успешно активирован/деактивирован!')
            );
        }
        catch(Exception $e)
        {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                $e->getMessage()
            );
        }

        Yii::app()->cache->flush();

        $referrer = Yii::app()->getRequest()->getUrlReferrer();
        $this->redirect($referrer !== null ? $referrer : array("/yupe/backend"));
    }

    /**
     * Метод для загрузки файлов из редактора при создании контента
     *
     * @since 0.4
     *
     * Подробнее http://imperavi.com/redactor/docs/images/
     */
    public function actionAjaxFileUpload()
    {
        if (!empty($_FILES['file']['name']))
        {
            $rename     = (bool) Yii::app()->request->getQuery('rename', true);
            $webPath    = '/' . $this->yupe->uploadPath . '/' . date('dmY') . '/';
            $uploadPath = Yii::getPathOfAlias('webroot') . $webPath;

            if (!is_dir($uploadPath))
            {
                if (!@mkdir($uploadPath))
                    Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'Не удалось создать каталог "{dir}" для файлов!', array('{dir}' => $uploadPath)));
            }

            $file = CUploadedFile::getInstanceByName('file');

            if ($file)
            {
                //сгенерировать имя файла и сохранить его
                $newFileName = $rename ? md5(time() . uniqid() . $file->name) . '.' . $file->extensionName : $file->name;

                if (!$file->saveAs($uploadPath . $newFileName))
                    Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'При загрузке произошла ошибка!'));

                Yii::app()->ajax->rawText(CJSON::encode(array(
                    'filelink' => Yii::app()->baseUrl . $webPath . $newFileName,
                    'filename' => $file->name
                )));
            }
        }
        Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'При загрузке произошла ошибка!'));
    }

    /**
     * Очистка кэша сайта
     *
     * @since 0.4
     *
     */
    public function actionCacheflush()
    {
        Yii::app()->cache->flush();
        $dirsList = glob(Yii::app()->assetManager->getBasePath() . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
        if (is_array($dirsList)) {
            foreach ($dirsList as $item) {
                YFile::rmDir($item);
            }
        }
        Yii::app()->user->setFlash(
            YFlashMessages::NOTICE_MESSAGE,
            Yii::t('YupeModule.yupe', 'Кэш успешно сброшен!')
        );
        $this->redirect(Yii::app()->request->urlReferrer !== null ? Yii::app()->request->urlReferrer : array("/yupe/backend"));
    }

    /**
     * Страничка для отображения ссылок на ресурсы для получения помощи
     *
     * @since 0.4
     *
     */
    public function actionHelp()
    {
        $this->render('help');
    }

    public function actionModupdate($name=null)
    {
        if($name && ($module=Yii::app()->getModule($name)))
        {
             $updates = Yii::app()->migrator->checkForUpdates(array($name=>$module));
             if(Yii::app()->request->isPostRequest)
             {
                Yii::app()->migrator->updateToLatest($name);
                Yii::app()->user->setFlash(
                     YFlashMessages::NOTICE_MESSAGE,
                     Yii::t('YupeModule.yupe', 'Модуль обновил свои миграции!')
                 );
                $this->redirect(array("/yupe/backend"));
             } else
                $this->render('modupdate', array( 'updates'=> $updates, 'module' => $module));
             return;
        }

        //$this->render('modupdate_index', array());
        throw new CHttpException(500,'not implemented yet');

    }
}

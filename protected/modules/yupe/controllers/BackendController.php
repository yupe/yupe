<?php

class BackendController extends YBackController
{

    /**
     * Метод который выполняется перед экшеном
     *
     * @param class $action - екземпляр экшена
     *
     * @return parent::beforeAction()
     **/
    public function beforeAction($action)
    {
        Yii::app()->clientScript->registerScript(
            'yupeToken', 'var actionToken = ' . json_encode(
                array(
                    'token'      => Yii::app()->request->csrfTokenName . '=' . Yii::app()->request->csrfToken,
                    'url'        => $this->createAbsoluteUrl('backend/modulestatus'),
                    'message'    => Yii::t('YupeModule.yupe', 'Подождите, идёт обработка вашего запроса'),
                    'error'      => Yii::t('YupeModule.yupe', 'Во время обработки вашего запроса произошла неизвестная ошибка'),
                    'loadingimg' => CHtml::image(
                        '/web/booster-install/assets/img/progressbar.gif', '', array(
                            'style' => 'width: 100%; height: 20px;',
                        )
                    ),
                    'buttons'    => array(
                        'yes'    => Yii::t('YupeModule.yupe', 'Да'),
                        'no'     => Yii::t('YupeModule.yupe', 'Отмена'),
                    ),
                    'messages'   => array(
                        'confirm_deactivate'       => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите отключить модуль?'),
                        'confirm_activate'         => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите включить модуль?'),
                        'confirm_uninstall'        => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить модуль?') . '<br />' . Yii::t('YupeModule.yupe', 'Все данные модуля буду удалены.'),
                        'confirm_install'          => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите установить модуль?') . '<br />' . Yii::t('YupeModule.yupe', 'Будут добавлены новые данные для работы модуля.'),
                        'confirm_cacheFlush'       => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить весь кеш?'),
                        'confirm_assetsFlush'      => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить все ресурсы (assets)?'),
                        'confirm_cacheAssetsFlush' => Yii::t('YupeModule.yupe', 'Вы уверены, что хотите удалить весь кеш и все ресурсы (assets)?') . '<br />' . Yii::t('YupeModule.yupe', 'Стоит учесть, что это трудоёмкий процесс и может занять некоторое время!'),
                        'unknown'                  => Yii::t('YupeModule.yupe', 'Выбрано неизвестное действие.'),
                    )
                )
            ), CClientScript::POS_BEGIN
        );

        return parent::beforeAction($action);
    }

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
        $paramGroups        = $module->getEditableParamsGroups();
        
        // разберем элементы по группам
        $mainParams = array();
        $elements = array();
        foreach( $paramGroups as $name => $group ){
            $layout = isset($group["items"]) ? array_fill_keys($group["items"], $name) : array();
            $label = isset($group['label']) ? $group['label'] : $name ;

            if( $name === 'main' ){
                if( $label !== $name )
                    $mainParams["paramsgroup_".$name]= CHtml::tag("h4",array(), $label);
                    
                $mainParams = array_merge($mainParams, $layout);
            } else {
                $elements["paramsgroup_".$name]= CHtml::tag("h4",array(), $label);
                $elements = array_merge($elements, $layout);
            }
        }
                
        foreach ($module as $key => $value)
        {
            if (array_key_exists($key, $editableParams))
                $element = CHtml::label($moduleParamsLabels[$key], $key) .
                                  CHtml::dropDownList($key, $value, $editableParams[$key], array('empty' => Yii::t('YupeModule.yupe', '--выберите--'), 'class' => 'span10'));

            else if (in_array($key, $editableParams))
                $element = CHtml::label((isset($moduleParamsLabels[$key]) ? $moduleParamsLabels[$key] : $key), $key) .
                                  CHtml::textField($key, $value, array('maxlength' => 300, 'class' => 'span10'));
            else
                unset($element);
            
            if( isset($element) )                      
                if( array_key_exists($key, $elements) ){
                    $elements[$key] = $element;
                } else 
                {
                    $mainParams[$key] = $element;
                }
        }

        // разместим в начале основные параметры 
        $elements = array_merge($mainParams, $elements);
        
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
    public function actionModuleChange($name = null, $status)
    {
        if (!empty($name) && $name != 'install' && ($module = Yii::app()->getModule($name)) == null)
            $module = $this->yupe->getCreateModule($name);
        if (!empty($module)) {
            try
            {
                if ($status == 0) {
                    if ($module->isActive) {
                        $module->deActivate;
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('YupeModule.yupe', 'Модуль успешно отключен!')
                        );
                    } else {
                        $module->unInstall;
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('YupeModule.yupe', 'Модуль успешно деинсталлирован!')
                        );
                    }
                } else {
                    if ($module->isInstalled) {
                        $module->activate;
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('YupeModule.yupe', 'Модуль успешно включен!')
                        );
                    } else {
                        $module->install;
                        Yii::app()->user->setFlash(
                            YFlashMessages::NOTICE_MESSAGE,
                            Yii::t('YupeModule.yupe', 'Модуль успешно установлен!')
                        );
                    }
                }
    
                Yii::app()->cache->flush();
            }
            catch(Exception $e)
            {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        } else
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('YupeModule.yupe', 'Модуль не найден или его включение запрещено!')
            );

        $referrer = Yii::app()->getRequest()->getUrlReferrer();
        $this->redirect($referrer !== null ? $referrer : array("/yupe/backend"));
    }

    /**
     * Обновленик миграций модуля
     *
     * @param string $name - id модуля
     *
     * @return nothing
     */
    public function actionModupdate($name = null)
    {
        if ($name) {
            if (($module = Yii::app()->getModule($name)) == null)
                $module = $this->yupe->getCreateModule($name);

            if ($module->isInstalled) {
                $updates = Yii::app()->migrator->checkForUpdates(array($name => $module));
                if (Yii::app()->request->isPostRequest) {
                    Yii::app()->migrator->updateToLatest($name);

                    Yii::app()->user->setFlash(
                        YFlashMessages::NOTICE_MESSAGE,
                        Yii::t('YupeModule.yupe', 'Модуль обновил свои миграции!')
                    );
                    $this->redirect(array("/yupe/backend"));
                } else
                    $this->render('modupdate', array('updates' => $updates, 'module' => $module));
            } else
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Модуль еще не установлен!')
                );
        } else
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('YupeModule.yupe', 'Не указано имя модуля!')
            );

        $this->redirect(Yii::app()->request->urlReferrer !== null ? Yii::app()->request->urlReferrer : array("/yupe/backend"));
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
     * @return nothing
     */
    public function actionHelp()
    {
        $this->render('help');
    }

    /**
     * Действие для управления модулями:
     *
     * @return string json-data
     **/
    public function actionModulestatus()
    {
        /**
         * Если это не POST-запрос - посылаем лесом:
         **/
        if (!Yii::app()->request->isPostRequest || !Yii::app()->request->isAjaxRequest)
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        /**
         * Получаем название модуля и проверяем,
         * возможно модуль необходимо подгрузить
         **/
        if (($name = Yii::app()->request->getPost('module'))
            && ($status = Yii::app()->request->getPost('status')) !== null
            && ($module = Yii::app()->getModule($name)) === null
            && $name != 'install'
        )
            $module = $this->yupe->getCreateModule($name);
        /**
         * Если статус неизвестен - ошибка:
         **/
        elseif (!isset($status) || !in_array($status, array(0, 1)))
            Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Не указан статус для обработки!'));

        /**
         * Если всё в порядке - выполняем нужное действие:
         **/
        if (isset($module) && !empty($module)) {
            try {
                switch ($status) {
                case 0:
                    if ($module->isActive) {
                        $module->deActivate;
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно отключен!');
                    } else {
                        $module->unInstall;
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно деинсталлирован!');
                    }
                    break;
                
                case 1:
                    if ($module->isInstalled) {
                        $module->activate;
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно включен!');
                    } else {
                        $module->install;
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно установлен!');
                    }
                    break;
                }
                $result = 1;
                Yii::app()->cache->flush();
            } catch(Exception $e) {
                $result = 0;
                $message = $e->getMessage();
            }

            /**
             * Возвращаем ответ:
             **/
            $result == 1
                ? Yii::app()->ajax->success($message)
                : Yii::app()->ajax->failure($message);

        } else
        /**
         * Иначе возвращаем ошибку:
         **/
            Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Модуль не найден или его включение запрещено!'));
    }

    /**
     * Метод очистки ресурсов (assets)
     *
     * @return boolean
     **/
    private function _cleanAssets()
    {
        try {
            $dirsList = glob(Yii::app()->assetManager->getBasePath() . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
            if (is_array($dirsList)) {
                foreach ($dirsList as $item) {
                    YFile::rmDir($item);
                }
            }
            return true;
        } catch(Exception $e) {
            Yii::app()->ajax->failure(
                $e->getMessage()
            );
        }
    }

    /**
     * Ajax-метод для очистки кеша и ресурсов (assets)
     *
     * @return void
     **/
    public function actionAjaxflush()
    {
        /**
         * Если это не POST-запрос - посылаем лесом:
         **/
        if (!Yii::app()->request->isPostRequest
            || !Yii::app()->request->isAjaxRequest
            || ($method = Yii::app()->request->getPost('method')) === null
        )
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

        switch ($method) {
        /**
         * Очистка только кеша:
         **/
        case 'cacheFlush':
            try {
                Yii::app()->cache->flush();
                Yii::app()->ajax->success(
                    Yii::t('YupeModule.yupe', 'Очистка кеша успешно завершена!')
                );
            } catch(Exception $e) {
                Yii::app()->ajax->failure(
                    $e->getMessage()
                );
            }
            break;
        /**
         * Очистка только ресурсов:
         **/
        case 'assetsFlush':
            if ($this->_cleanAssets()) {
                Yii::app()->ajax->success(
                    Yii::t('YupeModule.yupe', 'Очистка ресурсов успешно завершена!')
                );
            }
            break;
        /**
         * Очистка ресурсов и кеша:
         **/
        case 'cacheAssetsFlush':
            try {
                Yii::app()->cache->flush();
                if ($this->_cleanAssets()) {
                    Yii::app()->ajax->success(
                        Yii::t('YupeModule.yupe', 'Очистка ресурсов и кеша успешно завершена!')
                    );
                }
            } catch(Exception $e) {
                Yii::app()->ajax->failure(
                    $e->getMessage()
                );
            }
            break;
        /**
         * Использован неизвестный системе метод:
         **/
        default:
            Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Использован неизвестный системе метод!'));
            break;
        }
    }
}

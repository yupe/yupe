<?php
/**
 * Главный контроллер админ-панели,
 * который содержит методы для управления модулями,
 * а также их настройками.
 *
 * @category YupeController
 * @package  YupeCms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/

/**
 * Главный контроллер админ-панели:
 *
 * @category YupeController
 * @package  YupeCms
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
class BackendController extends YBackController
{
    /**
     * Экшен главной страницы панели управления:
     *
     * @return void
     **/
    public function actionIndex()
    {
        $this->render('index', $this->yupe->getModules(false, true));
    }

    /**
     * Экшен настройки модулей (список):
     *
     * @return void
     **/
    public function actionSettings()
    {
        $this->render('settings', $this->yupe->getModules(false, true));
    }

    /**
     * Экшен отображения настроек модуля:
     *
     * @param string $module - id-модуля
     *
     * @return void
     **/
    public function actionModulesettings($module)
    {
        if (!($module = Yii::app()->getModule($module)))
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница настроек данного модуля недоступна!'));

        $editableParams     = $module->getEditableParams();
        $moduleParamsLabels = $module->getParamsLabels();
        $paramGroups        = $module->getEditableParamsGroups();
        
        // разберем элементы по группам
        $mainParams = array();
        $elements = array();
        foreach ($paramGroups as $name => $group) {
            $layout = isset($group["items"])
                    ? array_fill_keys($group["items"], $name)
                    : array();
            $label  = isset($group['label'])
                    ? $group['label']
                    : $name ;

            if ($name === 'main') {
                if ($label !== $name){
                    $mainParams["paramsgroup_".$name] = CHtml::tag("h4", array(), $label);
                }
                $mainParams = array_merge($mainParams, $layout);
            } else {
                $elements["paramsgroup_" . $name] = CHtml::tag("h4", array(), $label);
                $elements = array_merge($elements, $layout);
            }
        }
                
        foreach ($module as $key => $value) {
            if (array_key_exists($key, $editableParams)) {
                $element = CHtml::label($moduleParamsLabels[$key], $key)
                        . CHtml::dropDownList(
                            $key, $value, $editableParams[$key], array(
                                'empty' => Yii::t('YupeModule.yupe', '--выберите--') ,
                                'class' => 'span10'
                            )
                        );
            } else {
                if (in_array($key, $editableParams)) {
                    $element = CHtml::label(
                        (isset($moduleParamsLabels[$key])
                            ? $moduleParamsLabels[$key]
                            : $key
                        ), $key
                    ) . CHtml::textField(
                        $key, $value, array(
                            'maxlength' => 300,
                            'class'     => 'span10'
                        )
                    );
                } else {
                    unset($element);
                }
            }
            if (isset($element)) {
                if (array_key_exists($key, $elements)) {
                    $elements[$key] = $element;
                } else {
                    $mainParams[$key] = $element;
                }
            }
        }

        // разместим в начале основные параметры 
        $elements = array_merge($mainParams, $elements);
        
        // сформировать боковое меню из ссылок на настройки модулей
        $this->menu = $this->yupe->modules['modulesNavigation'][$this->yupe->category]['items']['settings']['items'];

        $this->render(
            'modulesettings', array(
            'module'             => $module,
            'elements'           => $elements,
            'moduleParamsLabels' => $moduleParamsLabels,
            )
        );
    }

    /**
     * Экшен сохранения настроек модуля:
     *
     * @return void
     **/
    public function actionSaveModulesettings()
    {
        if (Yii::app()->request->isPostRequest) {
            if (!($moduleId = Yii::app()->request->getPost('module_id')))
                throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));

            if (!($module = Yii::app()->getModule($moduleId)))
                throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Модуль "{module}" не найден!', array('{module}' => $moduleId)));

            if (!$this->saveParamsSetting($moduleId, $module->editableParamsKey)) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t(
                        'YupeModule.yupe', 'Настройки модуля "{module}" сохранены!', array(
                            '{module}' => $module->getName()
                        )
                    )
                );
                Yii::app()->cache->clear($moduleId);
            } else {
                Yii::app()->user->setFlash(
                    YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'При сохранении произошла ошибка!')
                );
            }
            $this->redirect(array('/yupe/backend/modulesettings', 'module' => $moduleId));
        }
        throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Страница не найдена!'));
    }

    /**
     * Экшен настроек темы:
     *
     * @return void
     **/
    public function actionThemesettings()
    {
        if (Yii::app()->request->isPostRequest) {
            if (!$this->saveParamsSetting($this->yupe->coreModuleId, array('theme', 'backendTheme'))) {
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Настройки тем сохранены!')
                );
                Yii::app()->cache->clear('yupe');
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

        $this->render(
            'themesettings', array(
                'themes'        => $this->yupe->getThemes(),
                'theme'         => $theme,
                'backendThemes' => $this->yupe->getThemes(true),
                'backendTheme'  => $backendTheme,
            )
        );
    }

    /**
     * Метода сохранения настроек модуля:
     *
     * @param string $moduleId - идетификтор метода
     * @param array  $params   - массив настроек
     *
     * @return bool
     **/
    public function saveParamsSetting($moduleId, $params)
    {
        $settings = Settings::model()->fetchModuleSettings($moduleId, $params);

        foreach ($params as $p) {
            $pval = Yii::app()->request->getPost($p);
            // Если параметр уже был - обновим, иначе надо создать новый
            if (isset($settings[$p])) {
                // Если действительно изменили настройку
                if ($settings[$p]->param_value != $pval) {
                    $settings[$p]->param_value = $pval;
                    // Добавляем для параметра его правила валидации
                    $settings[$p]->rulesFromModule = Yii::app()->getModule($moduleId)->getRulesForParam($p);
                    if (!$settings[$p]->save())
                        return true;
                }
            } else {
                $settings[$p] = new Settings;

                $settings[$p]->setAttributes(
                    array(
                        'module_id'   => $moduleId,
                        'param_name'  => $p,
                        'param_value' => $pval,
                    )
                );

                if (!$settings[$p]->save())
                    return true;
            }
        }
        return false;
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

            if ($module->getIsInstalled()) {
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
        } else {
            Yii::app()->user->setFlash(
                YFlashMessages::ERROR_MESSAGE,
                Yii::t('YupeModule.yupe', 'Не указано имя модуля!')
            );

            $this->redirect(Yii::app()->request->urlReferrer !== null ? Yii::app()->request->urlReferrer : array("/yupe/backend"));
        }
    }

    /**
     * Метод для загрузки файлов из редактора при создании контента
     *
     * @since 0.4
     *
     * Подробнее http://imperavi.com/redactor/docs/images/
     *
     * @return void
     */
    public function actionAjaxFileUpload()
    {
        if (!empty($_FILES['file']['name'])) {
            $rename     = (bool) Yii::app()->request->getQuery('rename', true);
            $webPath    = '/' . $this->yupe->uploadPath . '/' . date('dmY') . '/';
            $uploadPath = Yii::getPathOfAlias('webroot') . $webPath;

            if (!is_dir($uploadPath)) {
                if (!@mkdir($uploadPath))
                    Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'Не удалось создать каталог "{dir}" для файлов!', array('{dir}' => $uploadPath)));
            }

            $this->disableProfilers();

            $file = CUploadedFile::getInstanceByName('file');

            if ($file) {
                //сгенерировать имя файла и сохранить его
                $newFileName = $rename ? md5(time() . uniqid() . $file->name) . '.' . $file->extensionName : $file->name;

                if (!$file->saveAs($uploadPath . $newFileName))
                    Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'При загрузке произошла ошибка!'));

                Yii::app()->ajax->rawText(
                    json_encode(
                        array(
                            'filelink' => Yii::app()->baseUrl . $webPath . $newFileName,
                            'filename' => $file->name
                        )
                    )
                );
            }
        }
        Yii::app()->ajax->rawText(Yii::t('YupeModule.yupe', 'При загрузке произошла ошибка!'));
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
            && (($module = Yii::app()->getModule($name)) === null || $module->canActivate())
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
            $result  = false;
            try {
                switch ($status) {
                case 0:
                    if ($module->getIsActive()) {
                        $module->getDeActivate();
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно отключен!');
                    } else {
                        $module->getUnInstall();
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно деинсталлирован!');
                    }
                    $result = true;
                    break;
                
                case 1:
                    if ($module->getIsInstalled()) {
                        $module->getActivate();
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно включен!');
                    } else {
                        $module->getInstall();
                        $message = Yii::t('YupeModule.yupe', 'Модуль успешно установлен!');
                    }
                    $result = true;
                    break;
                case 2:
                    $message = ($result = $module->getActivate(false, true)) === true
                        ? Yii::t('YupeModule.yupe', 'Файл настроек модуля "{n}" успешно обновлён!', $name)
                        : Yii::t('YupeModule.yupe', 'При обновлении файла настроек модуля "{n}" произошла ошибка!', $name);
                    Yii::app()->user->setFlash(
                        $result ? YFlashMessages::NOTICE_MESSAGE : YFlashMessages::ERROR_MESSAGE,
                        $message
                    );
                    break;
                default:
                    $message = Yii::t('YupeModule.yupe', 'Выбрано неизвестное действие!');
                    break;
                }
                if (in_array($status, array(0, 1)))
                Yii::app()->cache->clear($name);
            } catch(Exception $e) {
                $message = $e->getMessage();
            }

            /**
             * Возвращаем ответ:
             **/
            $result === true
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

    /**
     * Сообщить об ошибке
     *
     * @return void
     **/
    public function actionReportBug()
    {
        $form = new BugForm;

        if (Yii::app()->request->isPostRequest && ($bugData = Yii::app()->request->getPost('BugForm'))) {
            $form->setAttributes($bugData);
            if ($form->validate()) {
                if ($form->module === BugForm::OTHER_MODULE){
                    $form->module = Yii::t('YupeModule.yupe', 'Другой модуль');
                }
                Yii::app()->mail->send(
                    Yii::app()->user->email,
                    $form->sendTo,
                    "[Bug in {$form->module}] " . $form->subject,
                    $form->message
                );
                Yii::app()->user->setFlash(
                    YFlashMessages::NOTICE_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Сообщение отправлено!')
                );
                $this->redirect('/yupe/backend/reportBug');
            }
        }

        $this->render(
            'reportBug', array(
                'model' => $form
            )
        );
    }
}

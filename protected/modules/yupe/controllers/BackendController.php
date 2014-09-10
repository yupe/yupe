<?php
/**
 * Главный контроллер админ-панели,
 * который содержит методы для управления модулями,
 * а также их настройками.
 *
 * @category YupeController
 * @package  yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/

/**
 * Главный контроллер админ-панели:
 *
 * @category YupeController
 * @package  yupe.modules.yupe.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
use yupe\models\Settings;

class BackendController extends yupe\components\controllers\BackController
{
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('index')),
            array('allow', 'actions' => array('error')),
            array('deny',),
        );
    }

    public function actions()
    {
        return array(
            'AjaxFileUpload' => array(
                'class'     => 'yupe\components\actions\YAjaxFileUploadAction',
                'maxSize'   => $this->module->maxSize,
                'mimeTypes' => $this->module->mimeTypes,
                'types'     => $this->module->allowedExtensions
            ),
        );
    }

    /**
     * Экшен главной страницы панели управления:
     *
     * @return void
     **/
    public function actionIndex()
    {
        $this->render('index', Yii::app()->moduleManager->getModules(false, false));
    }

    /**
     * Экшен настройки модулей (список):
     *
     * @return void
     **/
    public function actionSettings()
    {
        $this->hideSidebar = true;
        $this->render('settings', Yii::app()->moduleManager->getModules(false, true));
    }

    /**
     * Экшен сброса кеш-файла настроек:
     *
     * @throws CHttpException
     * @return void
     **/
    public function actionFlushDumpSettings()
    {
        if (Yii::app()->getRequest()->getIsAjaxRequest() == false) {
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Page was not found!'));
        }

        if (!Yii::app()->configManager->isCached()) {
            Yii::app()->ajax->failure(
                Yii::t('YupeModule.yupe', 'There is no cached settings')
            );
        }

        $message = array(
            'success' => Yii::t('YupeModule.yupe', 'Settings cache was reset successfully'),
            'failure' => Yii::t('YupeModule.yupe', 'There was an error when processing the request'),
        );

        try {

            $result = Yii::app()->configManager->flushDump();

        } catch (Exception $e) {
            Yii::app()->ajax->failure(
                Yii::t(
                    'YupeModule.yupe',
                    'There is an error: {error}',
                    array(
                        '{error}' => implode('<br />', (array)$e->getMessage())
                    )
                )
            );
        }

        $action = $result == false
            ? 'failure'
            : 'success';

        Yii::app()->ajax->$action($message[$action]);
    }

    /**
     * Экшен отображения настроек модуля:
     *
     * @throws CHttpException
     *
     * @param string $module - id-модуля
     *
     * @return void
     **/
    public function actionModulesettings($module)
    {
        if (!($module = Yii::app()->getModule($module))) {
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Setting page for this module is not available!'));
        }

        $editableParams = $module->getEditableParams();
        $moduleParamsLabels = $module->getParamsLabels();
        $paramGroups = $module->getEditableParamsGroups();

        // разберем элементы по группам
        $mainParams = array();
        $elements = array();
        foreach ($paramGroups as $name => $group) {
            $layout = isset($group["items"])
                ? array_fill_keys($group["items"], $name)
                : array();
            $label = isset($group['label'])
                ? $group['label']
                : $name;

            if ($name === 'main') {
                if ($label !== $name) {
                    $mainParams["paramsgroup_" . $name] = CHtml::tag("h4", array(), $label);
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
                        $key,
                        $value,
                        $editableParams[$key],
                        array(
                            'empty' => Yii::t('YupeModule.yupe', '--choose--'),
                            'class' => 'form-control'
                        )
                    );
            } else {
                if (in_array($key, $editableParams)) {
                    $element = CHtml::label(
                            (isset($moduleParamsLabels[$key])
                                ? $moduleParamsLabels[$key]
                                : $key
                            ),
                            $key
                        ) . CHtml::textField(
                            $key,
                            $value,
                            array(
                                'maxlength' => 300,
                                'class'     => 'form-control'
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

        $this->render(
            'modulesettings',
            array(
                'module'             => $module,
                'elements'           => $elements,
                'moduleParamsLabels' => $moduleParamsLabels,
            )
        );
    }

    /**
     * Экшен сохранения настроек модуля:
     *
     * @throws CHttpException
     *
     * @return void
     **/
    public function actionSaveModulesettings()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            if (!($moduleId = Yii::app()->getRequest()->getPost('module_id'))) {
                throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Page was not found!'));
            }

            if (!($module = Yii::app()->getModule($moduleId))) {
                throw new CHttpException(404, Yii::t(
                    'YupeModule.yupe',
                    'Module "{module}" was not found!',
                    array('{module}' => $moduleId)
                ));
            }

            if ($this->saveParamsSetting($moduleId, $module->getEditableParamsKey())) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t(
                        'YupeModule.yupe',
                        'Settings for "{module}" saved successfully!',
                        array(
                            '{module}' => $module->getName()
                        )
                    )
                );
                $module->getSettings(true);
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'There is an error when saving settings!')
                );
            }
            $this->redirect($module->getSettingsUrl());
        }
        throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Page was not found!'));
    }

    /**
     * Экшен настроек темы:
     *
     * @return void
     **/
    public function actionThemesettings()
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {
            if ($this->saveParamsSetting($this->yupe->coreModuleId, array('theme', 'backendTheme'))) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Themes settings saved successfully!')
                );
                Yii::app()->cache->clear('yupe');
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'There is an error when saving settings!')
                );
            }
            $this->redirect(array('/yupe/backend/themesettings/'));
        }

        $settings = Settings::fetchModuleSettings('yupe', array('theme', 'backendTheme'));
        $noThemeValue = Yii::t('YupeModule.yupe', 'Theme is don\'t use');

        $theme = isset($settings['theme']) && $settings['theme']->param_value != ''
            ? $settings['theme']->param_value
            : $noThemeValue;
        $backendTheme = isset($settings['backendTheme']) && $settings['backendTheme']->param_value != ''
            ? $settings['backendTheme']->param_value
            : $noThemeValue;

        $this->render(
            'themesettings',
            array(
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
     * @param array $params - массив настроек
     *
     * @return bool
     **/
    public function saveParamsSetting($moduleId, $params)
    {
        $paramValues = array();

        // Перебираем все параметры модуля
        foreach ($params as $param_name) {
            $param_value = Yii::app()->getRequest()->getPost($param_name, null);
            // Если параметр есть в post-запросе добавляем его в массив
            if ($param_value !== null) {
                $paramValues[$param_name] = $param_value;
            }
        }

        // Запускаем сохранение параметров
        return Settings::saveModuleSettings($moduleId, $paramValues);
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
            if (($module = Yii::app()->getModule($name)) == null) {
                $module = Yii::app()->moduleManager->getCreateModule($name);
            }

            if ($module->getIsInstalled()) {
                $updates = Yii::app()->migrator->checkForUpdates(array($name => $module));
                if (Yii::app()->getRequest()->getIsPostRequest()) {
                    Yii::app()->migrator->updateToLatest($name);

                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('YupeModule.yupe', 'Module was updated their migrations!')
                    );
                    $this->redirect(array("index"));
                } else {
                    $this->render('modupdate', array('updates' => $updates, 'module' => $module));
                }
            } else {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Module doesn\'t installed!')
                );
            }
        } else {
            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('YupeModule.yupe', 'Module name is not set!')
            );

            $this->redirect(
                Yii::app()->getRequest()->getUrlReferrer() !== null ? Yii::app()->getRequest()->getUrlReferrer(
                ) : array("/yupe/backend")
            );
        }
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
                    yupe\helpers\YFile::rmDir($item);
                }
            }

            return true;
        } catch (Exception $e) {
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
        if (!Yii::app()->getRequest()->getIsPostRequest()
            || !Yii::app()->getRequest()->getIsAjaxRequest()
            || ($method = Yii::app()->getRequest()->getPost('method')) === null
        ) {
            throw new CHttpException(404, Yii::t('YupeModule.yupe', 'Page was not found!'));
        }

        switch ($method) {
            case 'cacheAll':

                try {
                    Yii::app()->cache->flush();
                    $this->_cleanAssets();
                    if (Yii::app()->configManager->isCached()) {
                        Yii::app()->configManager->flushDump();
                    }
                    Yii::app()->ajax->success(
                        Yii::t('YupeModule.yupe', 'Cache cleaned successfully!')
                    );

                } catch (Exception $e) {
                    Yii::app()->ajax->failure(
                        $e->getMessage()
                    );
                }
                break;

            /**
             * Очистка только кеша:
             **/
            case 'cacheFlush':
                try {
                    Yii::app()->cache->flush();
                    Yii::app()->ajax->success(
                        Yii::t('YupeModule.yupe', 'Cache cleaned successfully!')
                    );
                } catch (Exception $e) {
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
                        Yii::t('YupeModule.yupe', 'Assets cleaned successfully!')
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
                            Yii::t('YupeModule.yupe', 'Assets and cache cleaned successfully!')
                        );
                    }
                } catch (Exception $e) {
                    Yii::app()->ajax->failure(
                        $e->getMessage()
                    );
                }
                break;
            /**
             * Использован неизвестный системе метод:
             **/
            default:
                Yii::app()->ajax->failure(Yii::t('YupeModule.yupe', 'Unknown method use in system!'));
                break;
        }
    }

    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;

        if (empty($error) || !isset($error['code']) || !(isset($error['message']) || isset($error['msg']))) {
            $this->redirect(array('index'));
        }

        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            $this->render('error', array('error' => $error));
        }
    }
}

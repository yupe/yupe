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

/**
 * Class BackendController
 */
class BackendController extends yupe\components\controllers\BackController
{
    /**
     * @return array
     */
    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index']],
            ['allow', 'actions' => ['error']],
            ['allow', 'actions' => ['AjaxFileUpload']],
            ['allow', 'actions' => ['AjaxImageUpload']],
            ['allow', 'actions' => ['transliterate']],
            ['deny',],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'AjaxFileUpload' => [
                'class' => 'yupe\components\actions\YAjaxFileUploadAction',
                'maxSize' => $this->module->maxSize,
                'mimeTypes' => $this->module->mimeTypes,
                'types' => $this->module->allowedExtensions,
            ],
            'AjaxImageUpload' => [
                'class' => 'yupe\components\actions\YAjaxImageUploadAction',
                'maxSize' => $this->module->maxSize,
                'mimeTypes' => $this->module->mimeTypes,
                'types' => $this->module->allowedExtensions,
            ],
            'AjaxImageUploadCKE' => array(
                'class' => 'yupe\components\actions\YAjaxImageUploadCKEAction',
                'maxSize' => $this->module->maxSize,
                'mimeTypes' => $this->module->mimeTypes,
                'types' => $this->module->allowedExtensions,
            ),
        ];
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

        $message = [
            'success' => Yii::t('YupeModule.yupe', 'Settings cache was reset successfully'),
            'failure' => Yii::t('YupeModule.yupe', 'There was an error when processing the request'),
        ];

        try {

            $result = Yii::app()->configManager->flushDump();

        } catch (Exception $e) {
            Yii::app()->ajax->failure(
                Yii::t(
                    'YupeModule.yupe',
                    'There is an error: {error}',
                    [
                        '{error}' => implode('<br />', (array)$e->getMessage()),
                    ]
                )
            );
        }

        $action = $result == false
            ? 'failure'
            : 'success';

        Yii::app()->ajax->$action($message[$action]);
    }

    /**
     * Формирует поле для редактирование параметра модуля
     * @param \yupe\components\WebModule $module
     * @param $param
     * @return string
     */
    private function getModuleParamRow(\yupe\components\WebModule $module, $param)
    {
        $editableParams = $module->getEditableParams();
        $moduleParamsLabels = CMap::mergeArray($module->getParamsLabels(), $module->getDefaultParamsLabels());

        $res = CHtml::label($moduleParamsLabels[$param], $param);

        /* если есть ключ в массиве параметров, то значит этот параметр выпадающий список в вариантами */
        if (array_key_exists($param, $editableParams)) {
            $res .= CHtml::dropDownList(
                $param,
                $module->{$param},
                $editableParams[$param],
                ['class' => 'form-control', 'empty' => Yii::t('YupeModule.yupe', '--choose--')]
            );
        } else {
            $res .= CHtml::textField($param, $module->{$param}, ['class' => 'form-control']);
        }

        return $res;
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
        $paramGroups = $module->getEditableParamsGroups();

        $groups = [];

        foreach ($paramGroups as $name => $group) {
            $title = isset($group['label']) ? $group['label'] : $name;
            $groups[$title] = [];
            if (isset($group['items'])) {
                foreach ((array)$group['items'] as $item) {
                    /*удаляем элементы, которые были в группах*/
                    if (($key = array_search($item, $editableParams)) !== false) {
                        unset($editableParams[$key]);
                    } else {
                        unset($editableParams['item']);
                    }
                    unset($editableParams[$item]);
                    $groups[$title][] = $this->getModuleParamRow($module, $item);
                }
            }
        }

        /* если остались параметры без групп, то засунем их в одну группу */
        if ($editableParams) {
            $title = Yii::t('YupeModule.yupe', 'Other');
            $groups[$title] = [];
            foreach ((array)$editableParams as $key => $params) {
                /* из-за формата настроек параметров название атрибута будет или ключом, или значением */
                $groups[$title][] = $this->getModuleParamRow($module, is_string($key) ? $key : $params);
            }
        }

        $this->render('modulesettings', ['module' => $module, 'groups' => $groups,]);
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
                throw new CHttpException(
                    404, Yii::t(
                    'YupeModule.yupe',
                    'Module "{module}" was not found!',
                    ['{module}' => $moduleId]
                )
                );
            }

            if ($this->saveParamsSetting($moduleId, $module->getEditableParamsKey())) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t(
                        'YupeModule.yupe',
                        'Settings for "{module}" saved successfully!',
                        [
                            '{module}' => $module->getName(),
                        ]
                    )
                );
                $module->getSettings(true);
            } else {
                Yii::app()->getUser()->setFlash(
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
            if ($this->saveParamsSetting($this->yupe->coreModuleId, ['theme', 'backendTheme'])) {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Themes settings saved successfully!')
                );
                Yii::app()->getCache()->clear('yupe');
            } else {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'There is an error when saving settings!')
                );
            }
            $this->redirect(['/yupe/backend/themesettings/']);
        }

        $settings = Settings::fetchModuleSettings('yupe', ['theme', 'backendTheme']);
        $noThemeValue = Yii::t('YupeModule.yupe', 'Theme is don\'t use');

        $theme = isset($settings['theme']) && $settings['theme']->param_value != ''
            ? $settings['theme']->param_value
            : $noThemeValue;
        $backendTheme = isset($settings['backendTheme']) && $settings['backendTheme']->param_value != ''
            ? $settings['backendTheme']->param_value
            : $noThemeValue;

        $this->render(
            'themesettings',
            [
                'themes' => $this->yupe->getThemes(),
                'theme' => $theme,
                'backendThemes' => $this->yupe->getThemes(true),
                'backendTheme' => $backendTheme,
            ]
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
        $paramValues = [];

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

                $updates = Yii::app()->migrator->checkForUpdates([$name => $module]);

                if (Yii::app()->getRequest()->getIsPostRequest()) {

                    Yii::app()->migrator->updateToLatest($name);

                    Yii::app()->getUser()->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t('YupeModule.yupe', 'Module was updated their migrations!')
                    );
                    $this->redirect(["index"]);
                } else {
                    $this->render('modupdate', ['updates' => $updates, 'module' => $module]);
                }
            } else {
                Yii::app()->getUser()->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t('YupeModule.yupe', 'Module doesn\'t installed!')
                );
            }
        } else {
            Yii::app()->getUser()->setFlash(
                yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                Yii::t('YupeModule.yupe', 'Module name is not set!')
            );

            $this->redirect(
                Yii::app()->getRequest()->getUrlReferrer() !== null ? Yii::app()->getRequest()->getUrlReferrer(
                ) : ["/yupe/backend"]
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
        if(Yii::app()->getAssetManager()->linkAssets) {
            return true;
        }

        try {
            $dirsList = glob(Yii::app()->assetManager->getBasePath().DIRECTORY_SEPARATOR.'*', GLOB_ONLYDIR);
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
     * @throws CHttpException
     */
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
                    Yii::app()->getCache()->flush();
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
                    Yii::app()->getCache()->flush();
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
                    Yii::app()->getCache()->flush();
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

    /**
     *
     */
    public function actionError()
    {
        $error = Yii::app()->getErrorHandler()->error;

        if (empty($error) || !isset($error['code']) || !(isset($error['message']) || isset($error['msg']))) {
            $this->redirect(['index']);
        }

        if (!Yii::app()->getRequest()->getIsAjaxRequest()) {
            $this->render('error', ['error' => $error]);
        }
    }

    /**
     *
     */
    public function actionTransliterate()
    {
        $data = Yii::app()->getRequest()->getParam('data') ?: Yii::app()->getRequest()->getPost('data');

        echo \yupe\helpers\YText::translit($data);
    }
}

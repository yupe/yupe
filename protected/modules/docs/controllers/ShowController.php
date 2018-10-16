<?php

/**
 * Класс для отображения файлов документации:
 *
 * @category YupeController
 * @package  yupe.modules.docs.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
class ShowController extends \yupe\components\controllers\FrontController
{
    /**
     * Инициализируем контроллер:
     *
     * @return void
     **/
    public function init()
    {
        parent::init();

        $this->layout = 'withsidebar';
    }

    /**
     * Фильтры (используем для кеширования):
     *
     * @return void
     **/
    public function filters()
    {
        /**
         * Кеширование на уровне фильтрации можно отключить
         * достаточно изменить параметр в настройках модуля
         * (в веб-настройках, поумолчанию отключено):
         */
        if ($this->module->cachePages == 0) {
            return false;
        }

        $lcFile = $this->module->absoluteFilePath(Yii::app()->getRequest()->getParam('file'));

        return [
            [
                'COutputCache',
                'requestTypes' => ['GET'],
                'varyByParam'  => ['id', 'file'],
                'dependency'   => new CFileCacheDependency($lcFile),
            ]
        ];
    }

    /**
     * Экшен отображения документации:
     *
     * @param string $file - файл, который необходимо отобразить
     *
     * @return desctription of returned
     **/
    public function actionIndex($file = null)
    {
        if ($file === null) {
            $this->redirect(['/docs/show/index', 'file' => 'index']);
        }
        $moduleId = Yii::app()->getRequest()->getParam('moduleID');
        $moduleDocFolder = $module = null;
        if (!empty($moduleId)) {
            $module = Yii::app()->getModule(mb_strtolower($moduleId));
            if (!empty($module)) {
                $moduleDocFolder = "application.modules.{$moduleId}.{$module->docPath}";
            }
        }

        /**
         * @var $lcFile - в данную переменную помещаем абсолютный путь к файлу
         *                добавляя к нему текущий язык, но если файл не найден
         *                будет запрошен файл из языка поумолчанию
         * @var $type - получаем расширение файла
         */
        $lcFile = $this->module->absoluteFilePath($file, $moduleDocFolder);

        $type = pathinfo($lcFile, PATHINFO_EXTENSION);

        /**
         * Обработка страницы, получение контента или выдача ошибки:
         */
        switch (true) {

            /**
             * Обработка при несуществующем файле:
             */
            case !file_exists($lcFile):
                throw new CHttpException(404, Yii::t('DocsModule.docs', 'Docs page was not found'));
                break;

            /**
             * Обработка при MD-файлах и пустом контенте:
             */
            case in_array($type, explode(',', $this->module->fileExtMD)) && ($content = $this->module->renderMarkdown(
                    $lcFile
                )) === null:
                throw new CHttpException(404, Yii::t('DocsModule.docs', 'Docs page was not found or it\'s empty'));
                break;

            /**
             * Обработка при HTML-файлах и пустом контенте (файл не найден):
             */
            case in_array($type, explode(',', $this->module->fileExtHTML)) && ($content = file_get_contents(
                    $lcFile
                )) === null:
                throw new CHttpException(404, Yii::t('DocsModule.docs', 'Docs page was not found or it\'s empty'));
                break;
        }

        /**
         * Получаем заголовок для нашей страницы:
         */
        $this->pageTitle = ($title = $this->module->getDocTitle($content)) !== null
            ? $title . ' - ' . $this->module->name . ' - ' . $this->pageTitle
            : Yii::t('DocsModule.docs', 'Undefined title') . ' - ' . $this->module->name . ' - ' . $this->pageTitle;

        /**
         * Баг-фикс, если файл отрендерить без отображения,
         * может потеряться highlight.css .
         * Нашли вариант лучше - буду рад =)
         */
        Yii::app()->clientScript->registerCssFile(
            Yii::app()->getAssetManager()->publish(
                Yii::getPathOfAlias(
                    'system.vendors.TextHighlighter'
                ) . '/highlight.css'
            )
        );

        $this->render(
            'index',
            [
                'content' => $content,
                'title'   => $title,
                'module'  => $module,
                'mtime'   => date("d-m-Y H:i", filemtime($lcFile))
            ]
        );
    }
}

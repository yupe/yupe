<?php
/**
 * DocsBackendController - Класс для отображения файлов документации:
 *
 * @category YupeController
 * @package  yupe.modules.docs.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.6
 * @link     http://yupe.ru
 *
 **/
class DocsBackendController extends yupe\components\controllers\BackController
{
    /**
     * Инициализация контроллера:
     *
     * @return parent::init()
     **/
    public function init()
    {
        $this->menu = array(
            array('icon' => 'file', 'label' => Yii::t('DocsModule.docs', 'About module'), 'url' => array('/docs/docsBackend/index')),
            '',
            array(
                'label' => Yii::t('DocsModule.docs', 'Files'), 'items' => $this->module->renderProjectDocs()
            ),
        );

        return parent::init();
    }

    /**
     * Экшен главной страницы:
     *
     * @return void
     **/
    public function actionIndex()
    {
        $this->render('index');
    }

    /**
     * Экшен отрисовки статических файлов проекта:
     *
     * @param string $file - файл для рендеринга
     *
     * @return void
     *
     * @throws CHttpException
     **/
    public function actionShow($file = null)
    {

        if (($fileName = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $file) && !file_exists($fileName))
            throw new CHttpException(404, Yii::t('DocsModule.docs', 'Docs page was not found'));

        $content = $this->module->renderMarkdown($fileName);

        $this->pageTitle = ($title = $this->module->getDocTitle($content)) !== null
                           ? $title
                           : $file;

        $this->render(
            'show', array(
                'content' => $content,
                'title'   => $title,
            )
        );

    }
}
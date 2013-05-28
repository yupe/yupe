<?php
/**
 * Класс для отображения файлов документации:
 *
 * @category YupeController
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
class DefaultController extends YBackController
{
    /**
     * Инициализация контроллера:
     *
     * @return void
     **/
    public function init()
    {
        $this->menu = array(
            array('icon' => 'file', 'label' => Yii::t('DocsModule.docs', 'О модуле'), 'url' => array('/docs/default/index')),
            '',
            array(
                'label' => Yii::t('DocsModule.docs', 'Файлы'), 'items' => $this->module->renderProjectDocs()
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
     **/
    public function actionShow($file = null)
    {

        if (($fileName = Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . $file) && !file_exists($file))
            throw new CHttpException(404, Yii::t('DocsModule.Docs', 'Страница документации не найдена'));

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
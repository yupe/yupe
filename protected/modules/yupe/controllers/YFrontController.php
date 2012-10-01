<?php
/**
 * Контроллер отвечающий за front - часть
 */
class YFrontController extends YMainController
{
    public $menu        = array();
    public $breadcrumbs = array();
    /**
     * Описание сайта, меняется в админке
     */
    public $description;
    /**
     * Ключевые слова сайта, меняется в админке
     */
    public $keywords;

    /**
     * Устанавливает заголовок страниц
     * @param string $title заголовок
     */
    public function setPageTitle($title)
    {
        $this->pageTitle = $this->pageTitle . ' | ' . $title;
    }

    /**
     * Вызывается при инициализации YFrontController
     * Присваивает значения, необходимым переменным
     */
    public function init()
    {
        parent::init();

        $this->pageTitle   = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;
        $this->keywords    = $this->yupe->siteKeyWords;

        try
        {
            $yupeModule = Yii::app()->getModule('yupe');
            if ($yupeModule && $yupeModule->theme)
                Yii::app()->theme = $yupeModule->theme;
        }
        catch (CDbException $e)
        {
            Yii::app()->theme = 'default';
        }

        $baseUrl = Yii::app()->baseUrl;
        $fileUrl = Yii::app()->theme->basePath . "/" . ucwords(Yii::app()->theme->name) . "Theme.php";

        if (Yii::app()->theme && is_file($fileUrl))
            require($fileUrl);

        Yii::app()->clientScript->registerScript('yupe_base_url', "var baseUrl = '$baseUrl';", CClientScript::POS_HEAD);
    }
}
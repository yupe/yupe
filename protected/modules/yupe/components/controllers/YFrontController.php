<?php
/**
 * Контроллер отвечающий за front - часть
 */
class YFrontController extends YMainController
{
    /**
     * Хлебные крошки сайта, меняется в админке
     */
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
     * Вызывается при инициализации YFrontController
     * Присваивает значения, необходимым переменным
     */
    public function init()
    {
        parent::init();
        $this->pageTitle   = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;
        $this->keywords    = $this->yupe->siteKeyWords;
        if ($this->yupe->theme)
            Yii::app()->theme = $this->yupe->theme;
        else
            Yii::app()->theme = 'default';
    }
}
<?php
class PagesWidget extends YWidget
{
    public $pageStatus;
    public $topLevelOnly = false;
    public $order        = 'menu_order ASC';
    public $parent_id;
    public $view;
    public $visible = true;

    public function init()
    {
        parent::init();

        if (!$this->pageStatus)
            $this->pageStatus = Page::STATUS_PUBLISHED;
        $this->parent_id = (int) $this->parent_id;
    }

    public function run()
    {
        if ($this->visible)
        {
            $criteria = new CDbCriteria;
            $criteria->order = $this->order;
            $criteria->addCondition("status = {$this->pageStatus}");

            if (!Yii::app()->user->isAuthenticated())
                $criteria->addCondition('is_protected = ' . Page::PROTECTED_NO);
            if ($this->parent_id)
                $criteria->addCondition("id = {$this->parent_id} OR parent_id = {$this->parent_id}");
            if ($this->topLevelOnly)
                $criteria->addCondition("parent_id is null or parent_id = 0");

            $view = $this->view ? $this->view : 'pageswidget';

            // На данный момент хардкод, переделаю
            $menu = array(
                array('label' => Yii::t('PageModule.page', 'О проекте'), 'url' => array('/site/page', 'view' => 'about')),
                array('label' => Yii::t('PageModule.page', 'Документация'), 'url' => array('/site/page', 'view' => 'documents')),
                array('label' => Yii::t('PageModule.page', 'Сообщество'), 'url' => array('/site/page', 'view' => 'community')),
                array('label' => Yii::t('PageModule.page', 'Модули'), 'url' => array('/site/page', 'view' => 'modules')),
                array('label' => Yii::t('PageModule.page', 'Разработка'), 'url' => array('/site/page', 'view' => 'developement')),
            );

            $this->render($view, array(
                'pages' => Page::model()->cache($this->cacheTime)->findAll($criteria),
                'menu'  => $menu,
            ));
        }
    }
}
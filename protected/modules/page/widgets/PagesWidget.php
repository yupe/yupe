<?php
class PagesWidget extends YWidget
{
    public $pageStatus;
    public $topLevelOnly = false;
    public $order        = 't.order ASC, t.creation_date ASC';
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

            $this->render($view, array(
                'pages' => Page::model()->cache($this->cacheTime)->findAll($criteria),
            ));
        }
    }
}
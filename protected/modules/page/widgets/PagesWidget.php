<?php
class PagesWidget extends YWidget
{
    public $pageStatus;

    public $topLevelOnly = false;

    public $order = 'menu_order ASC';

    public $parent_Id;

    public $view;

    public $visible = true;

    public function init()
    {
        if (!$this->pageStatus)
        {
            $this->pageStatus = Page::STATUS_PUBLISHED;

            $this->parent_Id = (int)$this->parent_Id;
        }
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
            
            if ($this->parent_Id)            
                $criteria->addCondition("id = {$this->parent_Id} OR parent_Id = {$this->parent_Id}");
            
            if ($this->topLevelOnly)            
                $criteria->addCondition("parent_Id is null or parent_Id = 0");              

            $view = $this->view ? $this->view : 'pageswidget';

            $this->render($view, array(
                                      'pages' => Page::model()->findAll($criteria)
                                 ));
        }
    }
}
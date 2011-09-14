<?php
class PagesWidget extends YWidget
{
    public $pageStatus;

    public $topLevelOnly = false;

    public $order = 'parentId';

    public $parentId;

    public $view;

    public $visible = true;

    public function init()
    {
        if (!$this->pageStatus) {
            $this->pageStatus = Page::STATUS_PUBLISHED;
            $this->parentId = (int)$this->parentId;
        }
    }

    public function run()
    {
        if ($this->visible) {
            $criteria = new CDbCriteria();
            $criteria->order = $this->order;
            $criteria->addCondition("status = {$this->pageStatus}");
            if (!Yii::app()->user->isAuthenticated()) {
                $criteria->addCondition('isProtected = ' . Page::PROTECTED_NO);
            }
            if ($this->parentId) {
                $criteria->addCondition("id = {$this->parentId} OR parentId = {$this->parentId}");
            }
            if ($this->topLevelOnly) {
                $criteria->addCondition("parentId is null or parentId = 0");
            }

            $view = $this->view ? $this->view : 'pageswidget';

            $this->render($view, array(
                                      'pages' => Page::model()->findAll($criteria)
                                 ));
        }
    }
}

?>
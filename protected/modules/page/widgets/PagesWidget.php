<?php
/**
 * PagesWidget виджет для вывода страниц
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.page.widgets
 * @since 0.1
 *
 */
Yii::import('application.modules.page.models.*');

/**
 * Class PagesWidget
 */
class PagesWidget extends yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $pageStatus;
    /**
     * @var bool
     */
    public $topLevelOnly = false;
    /**
     * @var string
     */
    public $order = 't.order ASC, t.create_time ASC';
    /**
     * @var
     */
    public $parent_id;
    /**
     * @var string
     */
    public $view = 'pageswidget';
    /**
     * @var bool
     */
    public $visible = true;

    /**
     *
     */
    public function init()
    {
        parent::init();

        if (!$this->pageStatus) {
            $this->pageStatus = Page::STATUS_PUBLISHED;
        }

        $this->parent_id = (int)$this->parent_id;
    }

    /**
     * @throws CException
     */
    public function run()
    {
        if ($this->visible) {
            $criteria = new CDbCriteria();
            $criteria->order = $this->order;
            $criteria->addCondition("status = {$this->pageStatus}");

            if (!Yii::app()->user->isAuthenticated()) {
                $criteria->addCondition('is_protected = '.Page::PROTECTED_NO);
            }
            if ($this->parent_id) {
                $criteria->addCondition("id = {$this->parent_id} OR parent_id = {$this->parent_id}");
            }
            if ($this->topLevelOnly) {
                $criteria->addCondition("parent_id is null or parent_id = 0");
            }

            $this->render(
                $this->view,
                [
                    'pages' => Page::model()->cache($this->cacheTime)->findAll($criteria),
                ]
            );
        }
    }
}

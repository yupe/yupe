<?php
/**
 * Виджет для отрисовки группы блоков контента:
 *
 * @category YupeWidgets
 * @package  yupe.modules.contentblockgroup.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
Yii::import('application.modules.contentblock.models.ContentBlock');
Yii::import('application.modules.contentblock.ContentBlockModule');

class ContentBlockGroupWidget extends yupe\widgets\YWidget
{
    public $category;
    public $limit;
    public $silent = true;
    public $cacheTime = 60;
    public $rand = false;
    public $view = 'contentblockgroup';

    public function init()
    {
        if (empty($this->category)) {
            throw new CException(Yii::t(
                'ContentBlockModule.contentblock',
                'Insert group content block title for ContentBlockGroupWidget!'
            ));
        } else {
            $category = Category::model()->findByAttributes(['slug' => $this->category]);

            if (null === $category) {
                throw new CException(Yii::t(
                    'ContentBlockModule.contentblock',
                    'Category "{category}" does not exist, please enter the unsettled category',
                    [
                        '{category}' => $this->category
                    ]
                ));
            }
        }
        $this->silent = (bool)$this->silent;
        $this->cacheTime = (int)$this->cacheTime;
        $this->rand = (int)$this->rand;
    }

    public function run()
    {
        $cacheName = "ContentBlock{$this->category}" . Yii::app()->language;

        $blocks = Yii::app()->cache->get($cacheName);

        if ($blocks === false) {

            $category = Category::model()->findByAttributes(['slug' => $this->category]);

            $criteria = new CDbCriteria([
                'scopes' => ['active'],
            ]);
            $criteria->addCondition('category_id = :category_id');
            $criteria->params[':category_id'] = $category->id;

            if ($this->rand) {
                $criteria->order = 'RAND()';
            }

            if ($this->limit) {
                $criteria->limit = (int)$this->limit;
            }

            $blocks = ContentBlock::model()->findAll($criteria);

            if (empty($blocks) && $this->silent === false) {
                throw new CException(
                    Yii::t(
                        'ContentBlockModule.contentblock',
                        'Group content block "{category_id}" was not found !',
                        [
                            '{category_id}' => $this->category
                        ]
                    )
                );
            }

            Yii::app()->cache->set($cacheName, $blocks, $this->cacheTime);
        }

        $this->render($this->view, ['blocks' => $blocks]);
    }
}

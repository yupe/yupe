<?php
/**
 * Виджет для отрисовки группы блоков контента:
 *
 * @category YupeWidgets
 * @package  yupe.modules.contentblockgroup.widgets
 * @author   Yupe Team <support@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     https://yupe.ru
 *
 **/
Yii::import('application.modules.contentblock.models.ContentBlock');
Yii::import('application.modules.contentblock.ContentBlockModule');

/**
 * Class ContentBlockGroupWidget
 */
class ContentBlockGroupWidget extends yupe\widgets\YWidget
{
    /**
     * @var
     */
    public $category;
    /**
     * @var
     */
    public $limit;
    /**
     * @var bool
     */
    public $silent = true;
    /**
     * @var int
     */
    public $cacheTime = 60;
    /**
     * @var bool
     */
    public $rand = false;
    /**
     * @var string
     */
    public $view = 'contentblockgroup';

    /**
     * @throws CException
     */
    public function init()
    {
        if (empty($this->category)) {
            throw new CException(Yii::t(
                'ContentBlockModule.contentblock',
                'Insert group content block title for ContentBlockGroupWidget!'
            ));
        } else {
            $category = Yii::app()->getComponent('categoriesRepository')->getByAlias($this->category);

            if (null === $category) {
                throw new CException(Yii::t(
                    'ContentBlockModule.contentblock',
                    'Category "{category}" does not exist, please enter the unsettled category',
                    [
                        '{category}' => $this->category,
                    ]
                ));
            }
        }
        $this->silent = (bool)$this->silent;
        $this->cacheTime = (int)$this->cacheTime;
        $this->rand = (int)$this->rand;
    }

    /**
     * @throws CException
     */
    public function run()
    {
        $cacheName = "ContentBlock{$this->category}".Yii::app()->language;

        $blocks = Yii::app()->getCache()->get($cacheName);

        if ($blocks === false) {

            $category = Yii::app()->getComponent('categoriesRepository')->getByAlias($this->category);

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
                            '{category_id}' => $this->category,
                        ]
                    )
                );
            }

            Yii::app()->getCache()->set($cacheName, $blocks, $this->cacheTime);
        }

        $this->render($this->view, ['blocks' => $blocks]);
    }
}

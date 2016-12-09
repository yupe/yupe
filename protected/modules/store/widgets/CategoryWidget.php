<?php

Yii::import('application.modules.store.models.StoreCategory');

/**
 * Class CategoryWidget
 *
 * <pre>
 * <?php
 *    $this->widget('application.modules.store.widgets.CategoryWidget');
 * ?>
 * </pre>
 */
class CategoryWidget extends yupe\widgets\YWidget
{
    /**
     * @var int
     */
    public $parent = 0;

    /**
     * @var int
     */
    public $depth = 1;

    /**
     * @var string
     */
    public $view = 'category-widget';

    /**
     * @var array
     */
    public $htmlOptions = [];

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, [
            'tree' => (new StoreCategory())->published()->getMenuList($this->depth, $this->parent),
            'htmlOptions' => $this->htmlOptions,
        ]);
    }
}

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
    public $parent = 0;

    public $depth = 1;

    public $view = 'category-widget';

    public $htmlOptions = [];

    public function run()
    {
        $this->render($this->view,  [
            'tree' => (new StoreCategory())->published()->getMenuList($this->depth, $this->parent),
            'htmlOptions' => $this->htmlOptions
        ]);
    }
}

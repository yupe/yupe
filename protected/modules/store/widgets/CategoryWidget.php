<?php

Yii::import('application.modules.store.models.*');

/**
 * Class CategoryWidget
 *
 * <pre>
 * <?php $this->widget('application.modules.store.widgets.CategoryWidget',
 *  array(
 *      'layout' => 'main'
 *  ));
 * ?>
 * </pre>
 */
class CategoryWidget extends yupe\widgets\YWidget
{
    /**
     * @var string Id of elements
     */
    public $id;
    public $layout = '';
    public $htmlOptions;

    public $depth = 5;

    public function init()
    {

    }

    public function run()
    {
        $cat = new StoreCategory();
        $tree = $cat->getMenuList($this->depth);
        $this->render($this->layout ?: 'application.modules.store.views.widgets.CategoryWidget', array('items' => $tree, 'htmlOptions' => $this->htmlOptions));
    }
}

<?php

Yii::import('application.modules.shop.models.*');

/**
 * Class CategoryWidget
 *
 * <pre>
 * <?php $this->widget('application.modules.shop.widgets.CategoryWidget',
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
        $cat  = new ShopCategory();
        $tree = $cat->getMenuList($this->depth);
        $this->render($this->layout ? : 'application.modules.shop.views.widgets.CategoryWidget', array('items' => $tree, 'htmlOptions' => $this->htmlOptions));
    }
}
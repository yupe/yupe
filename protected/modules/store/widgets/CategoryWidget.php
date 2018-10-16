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
    public $depth = 1;

    public $view = 'category-widget';

    public $htmlOptions = [];

    public function run()
    {
        $this->render($this->view,  ['tree' => (new StoreCategory())->getMenuList($this->depth), 'htmlOptions' => $this->htmlOptions ]);
    }
}

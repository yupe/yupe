<?php
/**
 * Created by PhpStorm.
 * User: Michael
 * Date: 31.10.2014
 * Time: 4:58
 */

namespace yupe\widgets;

use Yii;

Yii::import('bootstrap.widgets.TbButtonColumn');

class CustomButtonColumn extends \TbButtonColumn
{
    /**
     * @var string the view button icon (defaults to 'eye-open').
     */
    public $viewButtonIcon = 'fa fa-fw fa-eye';

    /**
     * @var string the update button icon (defaults to 'pencil').
     */
    public $updateButtonIcon = 'fa fa-fw fa-pencil';

    /**
     * @var string the delete button icon (defaults to 'trash').
     */
    public $deleteButtonIcon = 'fa fa-fw fa-trash-o';

    public function renderFilterCell()
    {
        echo '<td class="button-column">';
        $this->renderButton('clear', [
            'label' => Yii::t('YupeModule.yupe', 'Clear Filters'),
            'icon' => 'fa fa-fw fa-undo',
            'url' => 'Yii::app()->controller->createUrl(Yii::app()->controller->action->ID,array("clearFilters"=>1))'
        ],[],[]);
        echo '</td>';
    }
}

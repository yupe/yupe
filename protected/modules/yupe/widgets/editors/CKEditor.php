<?php
namespace yupe\widgets\editors;

use Yii;
use CInputWidget;

class CKEditor extends \CInputWidget
{
    private $editorWidgetClass = 'bootstrap.widgets.TbCKEditor';

    public $options = array();

    public function run()
    {
        $this->widget(
            $this->editorWidgetClass,
            array(
                'model'         => $this->model,
                'attribute'     => $this->attribute,
                'name'          => $this->name,
                'editorOptions' => \CMap::mergeArray($this->getOptions(), $this->options),
            )
        );
    }

    public function getOptions()
    {
        return [];
    }
}

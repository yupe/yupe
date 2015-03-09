<?php
namespace yupe\widgets\editors;

use Yii;
use CInputWidget;

class WysiBB extends CInputWidget
{
    private $editorWidgetClass = 'vendor.brussens.wysibb-yii.WysiBBWidget';

    public $options = [];

    public function run()
    {
        $this->widget(
            $this->editorWidgetClass,
            [
                'model'     => $this->model,
                'attribute' => $this->attribute,
                'options'   => \CMap::mergeArray($this->getOptions(), $this->options),
            ]
        );
    }

    public function getOptions()
    {
        return [
            'buttons' => "bold,italic,underline,|,link,|,code,quote",
        ];
    }
}
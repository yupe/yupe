<?php
namespace yupe\widgets\editors;

use Yii;
use CInputWidget;

/**
 * Class WysiBB
 * @package yupe\widgets\editors
 */
class WysiBB extends CInputWidget
{
    /**
     * @var string
     */
    private $editorWidgetClass = 'vendor.brussens.wysibb-yii.WysiBBWidget';

    /**
     * @var array
     */
    public $options = [];

    /**
     * @throws \Exception
     */
    public function run()
    {
        $this->widget(
            $this->editorWidgetClass,
            [
                'model' => $this->model,
                'attribute' => $this->attribute,
                'options' => \CMap::mergeArray($this->getOptions(), $this->options),
            ]
        );
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return [
            'buttons' => "bold,italic,underline,|,link,|,code,quote",
        ];
    }
}
<?php
namespace yupe\widgets\editors;

use Yii;
use CInputWidget;
use CHtml;

class Textarea extends \CInputWidget
{

    public $options = array();

    public function run()
    {
        if ($this->model) {
            echo CHtml::activeTextArea(
                $this->model,
                $this->attribute,
                \CMap::mergeArray($this->getOptions(), $this->options)
            );
        } else {
            echo CHtml::textArea($this->name, $this->value, \CMap::mergeArray($this->getOptions(), $this->options));
        }
    }

    public function getOptions()
    {
        return [
            'class' => 'form-control',
            'rows'  => '10',
            'style' => 'resize: vertical;'
        ];
    }
}

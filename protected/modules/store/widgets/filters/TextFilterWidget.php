<?php

class TextFilterWidget extends \yupe\widgets\YWidget
{
    public $view = 'text-filter';

    public $attribute;

    public function init()
    {
        if (is_string($this->attribute)) {
            $this->attribute = Attribute::model()->findByAttributes(['name' => $this->attribute]);
        }

        if (!($this->attribute instanceof Attribute) || (int)$this->attribute->type !== Attribute::TYPE_SHORT_TEXT) {
            throw new Exception('Атрибут не найден или неправильного типа');
        }

        parent::init();
    }

    public function run()
    {
        $this->render($this->view, ['attribute' => $this->attribute]);
    }
} 

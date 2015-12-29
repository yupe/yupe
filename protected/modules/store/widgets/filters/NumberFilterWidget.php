<?php

/**
 * Class NumberFilterWidget
 */
class NumberFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'number-filter';

    /**
     * @var
     */
    public $attribute;

    /**
     * @throws Exception
     */
    public function init()
    {
        if (is_string($this->attribute)) {
            $this->attribute = Attribute::model()->findByAttributes(['name' => $this->attribute]);
        }

        if (!($this->attribute instanceof Attribute) || $this->attribute->type != Attribute::TYPE_NUMBER) {
            throw new Exception('Атрибут не найден или неправильного типа');
        }

        parent::init();
    }

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view, ['attribute' => $this->attribute]);
    }
} 

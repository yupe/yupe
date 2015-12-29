<?php

/**
 * Class DropdownFilterWidget
 */
class DropdownFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'dropdown-filter';

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

        if (!($this->attribute instanceof Attribute) || $this->attribute->type != Attribute::TYPE_DROPDOWN) {
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

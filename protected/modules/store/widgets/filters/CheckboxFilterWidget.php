<?php

/**
 * Class CheckboxFilterWidget
 */
class CheckboxFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'checkbox-filter';

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

        if (!($this->attribute instanceof Attribute) || $this->attribute->type != Attribute::TYPE_CHECKBOX) {
            throw new Exception(Yii::t('StoreModulle.store','Attribute error!'));
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

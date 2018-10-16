<?php
namespace store\components\validators;

use CNumberValidator;

/**
 * Class NumberValidator
 * @package store\components\validators
 */
class NumberValidator extends CNumberValidator
{
    /**
     * @var bool
     */
    public $replacingCommas = true;

    /**
     * @param \CModel $object
     * @param string $attribute
     */
    protected function validateAttribute($object, $attribute)
    {
        if ($this->replacingCommas === true) {
            $object->$attribute = str_replace(',', '.', $object->$attribute);
        }
        parent::validateAttribute($object, $attribute);
    }

    /**
     * @param \CModel $object
     * @param string $attribute
     * @return string|void
     */
    public function clientValidateAttribute($object, $attribute)
    {
        $js = parent::clientValidateAttribute($object, $attribute);
        if ($this->replacingCommas === true) {
            $js = 'value = value.replace(/,/g, "."); '.$js;
        }

        return $js;
    }
}

<?php
namespace store\components\validators;

use CNumberValidator;

class NumberValidator extends CNumberValidator
{
    public $replacingCommas = true;

    protected function validateAttribute($object, $attribute)
    {
        if ($this->replacingCommas === true) {
            $object->$attribute = str_replace(',', '.', $object->$attribute);
        }
        parent::validateAttribute($object, $attribute);
    }

    public function clientValidateAttribute($object, $attribute)
    {
        $js = parent::clientValidateAttribute($object, $attribute);
        if ($this->replacingCommas === true) {
            $js = 'value = value.replace(/,/g, "."); ' . $js;
        }
        return $js;
    }
}

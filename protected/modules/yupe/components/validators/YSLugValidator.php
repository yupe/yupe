<?php
/**
 * YSLugValidator - валидатор alias
 */
class YSLugValidator extends CValidator
{
    public function validateAttribute($object,$attribute)
    {
        $value = $object->$attribute;

        if (preg_match('/[^a-zA-Z0-9_\-]/', $value))
        {
            $message = ($this->message !== null)
                ? $this->message
                : Yii::t('YupeModule.yupe', '{attribute} содержит запрещенные символы');
            $this->addError($object, $attribute, $message);
        }
    }
}
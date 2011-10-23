<?php
class YRequiredValidator extends CValidator
{
    public $requiredValue;

    public $strict = false;

    public $allowEmpty = false;

    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;

        if ($this->allowEmpty && $this->isEmpty($value))
        {
            return;
        }

        if ($this->requiredValue !== null)
        {
            if (!$this->strict && $value != $this->requiredValue || $this->strict && $value !== $this->requiredValue)
            {
                $message = $this->message !== null ? $this->message
                    : Yii::t('yupe', '{attribute} must be {value}.',
                             array('{value}' => $this->requiredValue));
                $this->addError($object, $attribute, $message);
            }
        }
        else if ($this->isEmpty($value, true))
        {
            $message = $this->message !== null ? $this->message
                : Yii::t('yupe', '{attribute} cannot be blank.');
            $this->addError($object, $attribute, $message);
        }
    }
}
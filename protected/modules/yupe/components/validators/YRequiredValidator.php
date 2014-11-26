<?php
/**
 * Валидатор заполненности поля
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.yupe.components.validators
 * @since 0.1
 *
 */

namespace yupe\components\validators;

use CValidator;
use Yii;

class YRequiredValidator extends CValidator
{
    public $requiredValue;
    public $strict = false;
    public $allowEmpty = false;

    protected function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;

        if ($this->allowEmpty && $this->isEmpty($value)) {
            return;
        }

        if ($this->requiredValue !== null) {
            if (!$this->strict && $value != $this->requiredValue || $this->strict && $value !== $this->requiredValue) {
                $message = ($this->message !== null)
                    ? $this->message
                    : Yii::t(
                        'YupeModule.yupe',
                        '{attribute} must be {value}',
                        ['{value}' => $this->requiredValue]
                    );

                $this->addError($object, $attribute, $message);
            }
        } elseif ($this->isEmpty($value, true)) {
            $message = ($this->message !== null)
                ? $this->message
                : Yii::t('YupeModule.yupe', '{attribute} cannot be blank');

            $this->addError($object, $attribute, $message);
        }
    }
}

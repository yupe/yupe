<?php
/**
 * Валидатор заполненности поля
 *
 * @author yupe team <support@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.yupe.components.validators
 * @since 0.1
 *
 */

namespace yupe\components\validators;

use CValidator;
use Yii;

/**
 * Class YRequiredValidator
 * @package yupe\components\validators
 */
class YRequiredValidator extends CValidator
{
    /**
     * @var
     */
    public $requiredValue;
    /**
     * @var bool
     */
    public $strict = false;
    /**
     * @var bool
     */
    public $allowEmpty = false;

    /**
     * @param \CModel $object
     * @param string $attribute
     */
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

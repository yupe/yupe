<?php
/**
 * Валидатор поля типа slug или alias
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

class YSLugValidator extends CValidator
{
    public function validateAttribute($object, $attribute)
    {
        $value = $object->$attribute;

        if (preg_match('/[^a-zA-Z0-9_\-]/', $value)) {
            $message = ($this->message !== null)
                ? $this->message
                : Yii::t('YupeModule.yupe', '{attribute} have illegal characters');
            $this->addError($object, $attribute, $message);
        }
    }
}

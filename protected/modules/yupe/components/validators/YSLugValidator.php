<?php
/**
 * Валидатор поля типа slug или alias
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
 * Class YSLugValidator
 * @package yupe\components\validators
 */
class YSLugValidator extends CValidator
{
    /**
     * @param \CModel $object
     * @param string $attribute
     */
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

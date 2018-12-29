<?php

/**
 * Валидатор уникальности поля типа slug или alias
 *
 * @author Kucherov Anton <idexter.ru@gmail.com>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.yupe.components.validators
 * @since 0.1
 *
 */
namespace yupe\components\validators;

use CDbCriteria;
use CUniqueValidator;

/**
 * Class YUniqueSlugValidator
 * @package yupe\components\validators
 */
class YUniqueSlugValidator extends CUniqueValidator
{
    /**
     * @param \CModel $object
     * @param string $attribute
     * @throws \CException
     */
    protected function validateAttribute($object, $attribute)
    {
        $criteria = new CDbCriteria();
        $criteria->mergeWith($this->criteria);
        $criteria->addCondition('lang = :lang');
        $criteria->params[':lang'] = $object->lang;

        $this->criteria = $criteria;

        return parent::validateAttribute($object, $attribute);
    }
}

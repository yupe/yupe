<?php

/**
 * Валидатор уникальности поля типа slug или alias
 *
 * @author Kucherov Anton <idexter.ru@gmail.com>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.yupe.components.validators
 * @since 0.1
 *
 */
namespace yupe\components\validators;

use CUniqueValidator;

class YUniqueSlugValidator extends CUniqueValidator
{
    protected function validateAttribute($object, $attribute)
    {
        $this->criteria = ['condition' => 'lang = :lang', 'params' => [':lang' => $object->lang]];

        return parent::validateAttribute($object, $attribute);
    }
}

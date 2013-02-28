<?php

/**
 * YUniqueSlugValidator - валидатор проверки поля "slug"
 *
 * @author Kucherov Anton <idexter.ru@gmail.com>
 */
class YUniqueSlugValidator extends CUniqueValidator
{
    protected function validateAttribute( $object, $attribute )
    {
        $this->criteria = array('condition' => 'lang = :lang', 'params' => array(':lang' => $object->lang));
        return parent::validateAttribute( $object, $attribute );
    }
}
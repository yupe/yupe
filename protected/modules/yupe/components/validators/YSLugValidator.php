<?php
/**
 * Created by JetBrains PhpStorm.
 * User: andrey
 * Date: 12/21/12
 * Time: 11:23 PM
 * To change this template use File | Settings | File Templates.
 */
class YSLugValidator extends CValidator
{
    public function validateAttribute($object,$attribute)
    {
        $value = $object->$attribute;

        if(preg_match('/^[^a-zA-Z0-9_\-]+$/',$value))
        {
            $message = ($this->message !== null)
                ? $this->message
                : Yii::t('yupe', '{attribute} содержит запрещенные символы');

            $this->addError($object, $attribute, $message);
        }
    }
}

<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Model extends CActiveRecord
{
    public function attributeDescriptions()
    {
        return array();
    }

    public function getAttributeDescription($attribute)
    {
        $descriptions = $this->attributeDescriptions();

        if (isset($descriptions[$attribute]))
            return $descriptions[$attribute];
        else
            return '';
    }

}
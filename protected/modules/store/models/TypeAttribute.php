<?php

/**
 *
 * @property integer $type_id
 * @property integer $attribute_id
 *
 */
class TypeAttribute extends \yupe\models\YModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_type_attribute}}';
    }

    /**
     * @param null|string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}

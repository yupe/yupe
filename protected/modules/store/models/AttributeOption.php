<?php

/**
 *
 * @property integer $id
 * @property integer $attribute_id
 * @property string $value
 * @property integer $position
 *
 * @property-read Attribute $parent
 */
class AttributeOption extends \yupe\models\YModel
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_attribute_option}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Attribute the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('attribute_id, position', 'numerical', 'integerOnly' => true),
            array('value', 'length', 'max' => 255),
        );
    }


    public function relations()
    {
        return array(
            'parent' => array(self::BELONGS_TO, 'Attribute', 'attribute_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('StoreModule.attribute', 'Id'),
            'position' => Yii::t('StoreModule.attribute', 'Позиция'),
            'value' => Yii::t('StoreModule.attribute', 'Значение'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id' => Yii::t('StoreModule.attribute', 'Id'),
            'position' => Yii::t('StoreModule.attribute', 'Позиция'),
            'value' => Yii::t('StoreModule.attribute', 'Значение'),
        );
    }
}

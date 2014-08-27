<?php

/**
 *
 * @property integer $id
 * @property integer $main_category_id
 * @property string $categories
 * @property string $name
 * @property integer $position
 *
 * @property-read Attribute[] $typeAttributes
 * @property-read TypeAttribute[] $attributeRelation
 */
class Type extends \yupe\models\YModel
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_type}}';
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
            array('name', 'required'),
            array('name', 'unique'),
            array('name', 'length', 'max' => 255),
            array('main_category_id', 'numerical', 'integerOnly' => true),
            array('categories', 'safe'),
            array('id, name, main_category_id, categories', 'safe', 'on' => 'search'),
        );
    }

    public function relations()
    {
        return array(
            'attributeRelation' => array(self::HAS_MANY, 'TypeAttribute', 'type_id'),
            'typeAttributes' => array(self::HAS_MANY, 'Attribute', array('attribute_id' => 'id'), 'through' => 'attributeRelation', 'with' => 'group', 'order' => 'group.position ASC'),
            'category' => array(self::BELONGS_TO, 'StoreCategory', 'main_category_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('StoreModule.product', 'Id'),
            'name' => Yii::t('StoreModule.product', 'Название'),
            'main_category_id' => Yii::t('StoreModule.product', 'Категория'),
            'categories' => Yii::t('StoreModule.product', 'Дополнительные категории'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id' => Yii::t('StoreModule.product', 'Id'),
            'name' => Yii::t('StoreModule.product', 'Название'),
            'main_category_id' => Yii::t('StoreModule.product', 'Главная категория'),
            'categories' => Yii::t('StoreModule.product', 'Дополнительные категории'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(
            $this, array(
                'criteria' => $criteria,
            )
        );
    }

    public function setTypeAttributes($attributes)
    {
        TypeAttribute::model()->deleteAllByAttributes(array('type_id' => $this->id));

        if (is_array($attributes)) {
            foreach ($attributes as $attribute_id) {
                $typeAttribute = new TypeAttribute();
                $typeAttribute->type_id = $this->id;
                $typeAttribute->attribute_id = $attribute_id;
                $typeAttribute->save();
            }
        }
    }

    public function getFormattedList()
    {
        $types = Type::model()->findAll();
        $list = array();
        foreach ($types as $key => $type) {
            $list[$type->id] = $type->name;
        }
        return $list;
    }
}

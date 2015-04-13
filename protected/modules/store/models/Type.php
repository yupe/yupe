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
     * @return Type the static model class
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
        return [
            ['name', 'required'],
            ['name', 'unique'],
            ['name', 'length', 'max' => 255],
            ['main_category_id', 'numerical', 'integerOnly' => true],
            ['categories', 'safe'],
            ['id, name, main_category_id, categories', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'attributeRelation' => [self::HAS_MANY, 'TypeAttribute', 'type_id'],
            'typeAttributes' => [self::HAS_MANY, 'Attribute', ['attribute_id' => 'id'], 'through' => 'attributeRelation', 'with' => 'group', 'order' => 'group.position ASC'],
            'category' => [self::BELONGS_TO, 'StoreCategory', 'main_category_id'],
            'productCount' => [self::STAT, 'Product', 'type_id']
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'name' => Yii::t('StoreModule.store', 'Name'),
            'main_category_id' => Yii::t('StoreModule.store', 'Category'),
            'categories' => Yii::t('StoreModule.category', 'Additional categories'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'name' => Yii::t('StoreModule.store', 'Name'),
            'main_category_id' => Yii::t('StoreModule.store', 'Category'),
            'categories' => Yii::t('StoreModule.category', 'Additional categories'),
        ];
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
            $this, [
                'criteria' => $criteria,
            ]
        );
    }

    public function setTypeAttributes($attributes)
    {
        TypeAttribute::model()->deleteAllByAttributes(['type_id' => $this->id]);

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
        $list = [];
        foreach ($types as $key => $type) {
            $list[$type->id] = $type->name;
        }
        return $list;
    }
}

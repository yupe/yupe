<?php

/**
 *
 * @property integer $id
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
            ['categories', 'safe'],
            ['id, name', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'attributeRelation' => [self::HAS_MANY, 'TypeAttribute', 'type_id'],
            'typeAttributes' => [
                self::HAS_MANY,
                'Attribute',
                ['attribute_id' => 'id'],
                'through' => 'attributeRelation',
                'with' => 'group',
                'order' => 'group.position ASC',
            ],
            'productCount' => [self::STAT, 'Product', 'type_id'],
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


    /**
     * @param $attributes
     * @return bool
     */
    public function storeTypeAttributes(array $attributes)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            TypeAttribute::model()->deleteAllByAttributes(['type_id' => $this->id]);

            foreach ($attributes as $attributeId) {
                $typeAttribute = new TypeAttribute();
                $typeAttribute->type_id = $this->id;
                $typeAttribute->attribute_id = (int)$attributeId;
                $typeAttribute->save();
            }

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @return array
     */
    public function getFormattedList()
    {
        return CHtml::listData(Type::model()->findAll(), 'id', 'name');
    }

    /**
     * @return array
     */
    public function getAttributeGroups()
    {
        $attributeGroups = [];

        foreach ($this->typeAttributes as $attribute) {
            if ($attribute->group) {
                $attributeGroups[$attribute->group->name][] = $attribute;
            } else {
                $attributeGroups[Yii::t('StoreModule.store', 'Without a group')][] = $attribute;
            }
        }

        return $attributeGroups;
    }
}

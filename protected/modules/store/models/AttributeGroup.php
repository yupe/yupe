<?php

/**
 * This is the model class for table "store_attribute_group".
 *
 * @property integer $id
 * @property string $name
 * @property integer $position
 *
 * @property Attribute[] groupAttributes
 */
class AttributeGroup extends yupe\models\YModel
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_attribute_group}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'filter', 'filter' => 'trim'],
            ['name', 'length', 'max' => 255],
            ['id, name, position', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
            'groupAttributes' => [self::HAS_MANY, 'Attribute', 'group_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'ID'),
            'name' => Yii::t('StoreModule.store', 'Group title'),
            'position' => Yii::t('StoreModule.store', 'Position'),
        ];
    }

    public function behaviors()
    {
        return [
            'sortable' => [
                'class' => 'yupe\components\behaviors\SortableBehavior'
            ]
        ];
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('position', $this->position);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.position']
            ]
        );
    }

    public function getFormattedList()
    {
        $groups = $this->findAll(['order' => 'name ASC']);
        $list = [];
        foreach ($groups as $key => $group) {
            $list[$group->id] = $group->name;
        }
        return $list;
    }
}

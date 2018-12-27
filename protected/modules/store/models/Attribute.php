<?php

/**
 * This is the model class for table "Attribute".
 *
 * The followings are the available columns in table 'store_attribute':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $type
 * @property bool $required
 * @property integer $group_id
 * @property string $unit
 * @property integer $sort
 * @property integer $is_filter
 * @property string $description
 * @property-read AttributeOption[] $options
 * @property-read AttributeGroup $group
 *
 */
class Attribute extends \yupe\models\YModel
{
    /**
     *
     */
    const TYPE_TEXT = 0;
    /**
     *
     */
    const TYPE_SHORT_TEXT = 1;
    /**
     *
     */
    const TYPE_DROPDOWN = 2;
    /**
     *
     */
    const TYPE_CHECKBOX = 3;
    /**
     *
     */
    const TYPE_CHECKBOX_LIST = 4;

    /**
     *
     */
    const TYPE_NUMBER = 6;

    /**
     *
     */
    const TYPE_FILE = 7;

    /**
     * @var
     */
    public $rawOptions;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_attribute}}';
    }

    /**
     * @param null|string $className
     * @return $this
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
        return [
            ['name, title, description', 'filter', 'filter' => 'trim'],
            ['name, title, description', 'filter', 'filter' => 'strip_tags'],
            ['name, type, title', 'required'],
            ['name', 'unique'],
            [
                'name',
                'match',
                'pattern' => '/^([a-z0-9._-])+$/i',
                'message' => Yii::t('StoreModule.store', 'The name can contain only letters, numbers and underscores.'),
            ],
            ['type, group_id, sort, is_filter', 'numerical', 'integerOnly' => true],
            ['required', 'boolean'],
            ['unit', 'length', 'max' => 30],
            ['rawOptions', 'safe'],
            ['id, name, title, type, required, group_id', 'safe', 'on' => 'search'],
        ];
    }


    /**
     * @return array
     */
    public function relations()
    {
        return [
            'options' => [self::HAS_MANY, 'AttributeOption', 'attribute_id', 'order' => 'options.position ASC'],
            'group' => [self::BELONGS_TO, 'AttributeGroup', 'group_id'],
            'value' => [self::BELONGS_TO, 'AttributeValue', 'attribute_id'],
            'types' => [self::HAS_MANY, 'TypeAttribute', 'attribute_id'],
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'name' => Yii::t('StoreModule.store', 'Alias'),
            'title' => Yii::t('StoreModule.store', 'Title'),
            'type' => Yii::t('StoreModule.store', 'Type'),
            'required' => Yii::t('StoreModule.store', 'Required'),
            'group_id' => Yii::t('StoreModule.store', 'Group'),
            'unit' => Yii::t('StoreModule.store', 'Unit'),
            'sort' => Yii::t('StoreModule.store', 'Sort'),
            'is_filter' => Yii::t('StoreModule.store', 'Filter'),
            'description' => Yii::t('StoreModule.store', 'Description'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'name' => Yii::t('StoreModule.store', 'Alias'),
            'title' => Yii::t('StoreModule.store', 'Title'),
            'type' => Yii::t('StoreModule.store', 'Type'),
            'required' => Yii::t('StoreModule.store', 'Required'),
            'group_id' => Yii::t('StoreModule.store', 'Group'),
            'unit' => Yii::t('StoreModule.store', 'Unit'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->with = ['group'];

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('group_id', $this->group_id);
        $criteria->compare('is_filter', $this->is_filter);
        $criteria->compare('required', $this->required);

        $sort = new CSort;
        $sort->defaultOrder = 'group.position ASC, t.sort ASC';
        $sort->attributes = [
            '*',
            'title' => [
                'asc' => 'title',
                'desc' => 'title DESC',
            ],
        ];

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => $sort,
            ]
        );
    }

    /**
     * @return array
     */
    public function getTypesList()
    {
        return [
            self::TYPE_SHORT_TEXT => Yii::t('StoreModule.store', 'Short text (up to 250 characters)'),
            self::TYPE_TEXT => Yii::t('StoreModule.store', 'Text'),
            self::TYPE_DROPDOWN => Yii::t('StoreModule.store', 'Dropdown list'),
            self::TYPE_CHECKBOX => Yii::t('StoreModule.store', 'Checkbox'),
            self::TYPE_NUMBER => Yii::t('StoreModule.store', 'Number'),
            self::TYPE_FILE => Yii::t('StoreModule.store', 'File'),
            self::TYPE_CHECKBOX_LIST => Yii::t('StoreModule.store', 'Checkbox list'),
        ];
    }

    /**
     * @param $type
     * @return mixed
     */
    public function getTypeTitle($type)
    {
        $list = $this->getTypesList();

        return isset($list[$type]) ? $list[$type] : $type;
    }


    /**
     * @param $name
     * @return null|static
     */
    public function getAttributeByName($name)
    {
        return $name ? self::model()->findByAttributes(['name' => $name]) : null;
    }

    /**
     * @return string
     */
    public function getGroupTitle()
    {
        return $this->group instanceof AttributeGroup ? $this->group->name : '---';
    }

    /**
     * @param $type
     * @return bool
     */
    public function isType($type)
    {
        return $type == $this->type;
    }

    /**
     * @return bool
     */
    public function isRequired()
    {
        return $this->required;
    }

    /**
     * @param $currentType
     * @param $newType
     * @return bool
     */
    public function changeType($currentType, $newType)
    {
        if ($currentType == $newType) {
            return true;
        }

        $value = new AttributeValue();

        $currentCol = $value->column($currentType);
        $newCol = $value->column($newType);

        if ($currentCol == $newCol) {
            return true;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            Yii::app()->getDb()
                ->createCommand(sprintf('UPDATE {{store_product_attribute_value}} SET %s = %s WHERE attribute_id = :id',
                    $newCol, $currentCol))
                ->bindValue(':id', $this->id)
                ->execute();

            Yii::app()->getDb()
                ->createCommand(sprintf('UPDATE {{store_product_attribute_value}} SET %s = null WHERE attribute_id = :id',
                    $currentCol))
                ->bindValue(':id', $this->id)
                ->execute();

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
    public function behaviors()
    {
        return [
            'sortable' => [
                'class' => 'yupe\components\behaviors\SortableBehavior',
                'attributeName' => 'sort',
            ],
        ];
    }


    /**
     * @param array $types
     * @return bool
     * @throws CDbException
     */
    public function setTypes(array $types)
    {
        $transaction = Yii::app()->getDb()->beginTransaction();

        try {
            TypeAttribute::model()->deleteAll('attribute_id = :attribute', [
                ':attribute' => $this->id,
            ]);

            foreach ($types as $type) {
                $attribute = new TypeAttribute();
                $attribute->setAttributes([
                    'attribute_id' => $this->id,
                    'type_id' => (int)$type,
                ]);
                $attribute->save();
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
    public function getTypes()
    {
        $types = [];

        foreach ($this->types as $type) {
            $types[$type->type_id] = true;
        }

        return $types;
    }

    /**
     * @param array $attributes
     * @return bool
     * @throws CDbException
     */
    public function setMultipleValuesAttributes(array $attributes)
    {
        if (!$this->isMultipleValues()) {
            return true;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        try {

            foreach ($attributes as $attribute) {
                $model = new AttributeOption();
                $model->setAttributes([
                    'attribute_id' => $this->id,
                    'value' => trim($attribute),
                ]);

                if (false === $model->save()) {
                    throw new CDbException('Error save attribute...');
                }
            }

            $transaction->commit();

            return true;
        } catch (Exception $e) {
            $transaction->rollback();

            return false;
        }
    }

    /**
     * @return bool
     */
    public function isMultipleValues()
    {
        return $this->type == self::TYPE_DROPDOWN || $this->type == self::TYPE_CHECKBOX_LIST;
    }

    /**
     * @return array
     */
    public function getYesNoList()
    {
        return [
            Yii::t('StoreModule.store', 'No'),
            Yii::t('StoreModule.store', 'Yes'),
        ];
    }
}

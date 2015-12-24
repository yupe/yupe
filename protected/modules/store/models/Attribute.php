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
 *
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
    const TYPE_IMAGE = 5;
    /**
     *
     */
    const TYPE_NUMBER = 6;

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
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name, title', 'filter', 'filter' => 'trim'],
            ['name, type, title', 'required'],
            ['name', 'unique'],
            [
                'name',
                'match',
                'pattern' => '/^([a-z0-9._-])+$/i',
                'message' => Yii::t('StoreModule.store', 'The name can contain only letters, numbers and underscores.')
            ],
            ['type, group_id', 'numerical', 'integerOnly' => true],
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
            'value' => [self::BELONGS_TO, 'AttributeValue', 'attribute_id']
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
            'title' => Yii::t('StoreModule.store', 'Title'),
            'type' => Yii::t('StoreModule.store', 'Type'),
            'required' => Yii::t('StoreModule.store', 'Required'),
            'group_id' => Yii::t('StoreModule.store', 'Group'),
            'unit' => Yii::t('StoreModule.store', 'Unit'),
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

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('group_id', $this->group_id);

        $sort = new CSort;
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
                'sort' => $sort
            ]
        );
    }

    /**
     * @return array
     */
    public static function getTypesList()
    {
        return [
            self::TYPE_SHORT_TEXT => Yii::t('StoreModule.store', 'Short text (up to 250 characters)'),
            self::TYPE_TEXT => Yii::t('StoreModule.store', 'Text'),
            self::TYPE_DROPDOWN => Yii::t('StoreModule.store', 'Dropdown list'),
            //self::TYPE_CHECKBOX_LIST => Yii::t('StoreModule.store', 'Список чекбоксов'),
            self::TYPE_CHECKBOX => Yii::t('StoreModule.store', 'Checkbox'),
            //self::TYPE_IMAGE => Yii::t('StoreModule.store', 'Изображение'),
            self::TYPE_NUMBER => Yii::t('StoreModule.store', 'Число'),
        ];
    }

    /**
     * @param $type
     * @return mixed
     */
    public static function getTypeTitle($type)
    {
        $list = self::getTypesList();

        return $list[$type];
    }

    /**
     * @return array
     */
    public static function getTypesWithOptions()
    {
        return [self::TYPE_DROPDOWN, self::TYPE_CHECKBOX_LIST];
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
     * @throws CDbException
     */
    public function afterSave()
    {
        if ($this->type == Attribute::TYPE_DROPDOWN) {
            // список новых значений опций атрибута, не пустые, без лишних пробелов по бокам, уникальные
            $newOptions = array_unique(
                array_filter(
                    array_map('trim', explode("\n", $this->rawOptions))
                )
            );

            // в нижнем регистре, чтобы не надо было переназначать привязку атрибутов в товарах
            $newOptionsLower = array_map(
                function ($x) {
                    return mb_strtolower($x, 'utf-8');
                },
                $newOptions
            );

            $oldOptionsLower = []; // список имен опций, которые уже сохранены

            // удалим те из них, которых нет, в остальных обновим значение и позицию
            foreach ((array)$this->options as $option) {
                /* @var $option AttributeOption */
                $position = array_search(mb_strtolower($option->value), $newOptionsLower);
                // опция была удалена
                if ($position === false) {
                    $option->delete();
                } else {
                    $oldOptionsLower[] = mb_strtolower($option->value, 'utf-8');
                    $option->value = $newOptions[$position]; // если поменяли регистр опции
                    $option->position = $position;
                    $option->save();
                }
            }

            // добавим оставшиеся
            foreach (array_diff($newOptionsLower, $oldOptionsLower) as $position => $value) {
                $option = new AttributeOption();
                $option->attribute_id = $this->id;
                $option->value = $newOptions[$position];
                $option->position = $position;
                $option->save();
            }
        }

        parent::afterSave();
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
     * @return string Список опций, разделенных переносом строки
     */
    public function getRawOptions()
    {
        $tmp = '';
        foreach ((array)$this->options as $option) {
            $tmp .= $option->value . "\n";
        }
        return $tmp;
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
                ->createCommand(sprintf('UPDATE {{store_product_attribute_value}} SET %s = %s WHERE attribute_id = :id', $newCol, $currentCol))
                ->bindValue(':id', $this->id)
                ->execute();

            Yii::app()->getDb()
                ->createCommand(sprintf('UPDATE {{store_product_attribute_value}} SET %s = null WHERE attribute_id = :id', $currentCol))
                ->bindValue(':id', $this->id)
                ->execute();

            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }
}

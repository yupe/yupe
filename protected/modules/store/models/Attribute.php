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
    const TYPE_TEXT = 0;
    const TYPE_SHORT_TEXT = 1;
    const TYPE_DROPDOWN = 2;
    const TYPE_CHECKBOX = 3;
    const TYPE_CHECKBOX_LIST = 4;
    const TYPE_IMAGE = 5;
    const TYPE_NUMBER = 6;

    public $rawOptions;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_attribute}}';
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


    public function relations()
    {
        return [
            'options' => [self::HAS_MANY, 'AttributeOption', 'attribute_id', 'order' => 'options.position ASC'],
            'group' => [self::BELONGS_TO, 'AttributeGroup', 'group_id'],
        ];
    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'name' => Yii::t('StoreModule.attr', 'Name'),
            'title' => Yii::t('StoreModule.store', 'Title'),
            'type' => Yii::t('StoreModule.type', 'Type'),
            'required' => Yii::t('StoreModule.attr', 'Required'),
            'group_id' => Yii::t('StoreModule.attr', 'Group'),
            'unit' => Yii::t('StoreModule.attr', 'Unit'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'name' => Yii::t('StoreModule.attr', 'Name'),
            'title' => Yii::t('StoreModule.store', 'Title'),
            'type' => Yii::t('StoreModule.type', 'Type'),
            'required' => Yii::t('StoreModule.attr', 'Required'),
            'group_id' => Yii::t('StoreModule.attr', 'Group'),
            'unit' => Yii::t('StoreModule.attr', 'Unit'),
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

    public static function getTypesList()
    {
        return [
            self::TYPE_SHORT_TEXT => Yii::t('StoreModule.attr', 'Short text (up to 250 characters)'),
            self::TYPE_TEXT => Yii::t('StoreModule.attr', 'Text'),
            self::TYPE_DROPDOWN => Yii::t('StoreModule.attr', 'Dropdown list'),
            //self::TYPE_CHECKBOX_LIST => Yii::t('StoreModule.store', 'Список чекбоксов'),
            self::TYPE_CHECKBOX => Yii::t('StoreModule.attr', 'Checkbox'),
            //self::TYPE_IMAGE => Yii::t('StoreModule.store', 'Изображение'),
            self::TYPE_NUMBER => Yii::t('StoreModule.store', 'Число'),
        ];
    }

    public static function getTypeTitle($type)
    {
        $list = self::getTypesList();

        return $list[$type];
    }

    public function renderField($value = null, $name = null, $htmlOptions = [])
    {
        $name = $name ?: 'Attribute[' . $this->name . ']';
        switch ($this->type) {
            case self::TYPE_SHORT_TEXT:
                return CHtml::textField($name, $value, $htmlOptions);
                break;
            case self::TYPE_TEXT:
                return Yii::app()->getController()->widget(
                    Yii::app()->getModule('store')->getVisualEditor(),
                    [
                        'name' => $name,
                        'value' => $value
                    ],
                    true
                );
                break;
            case self::TYPE_DROPDOWN:
                $data = CHtml::listData($this->options, 'id', 'value');
                return CHtml::dropDownList($name, $value, $data, array_merge($htmlOptions, ($this->required ? [] : ['empty' => '---'])));
                break;
            case self::TYPE_CHECKBOX_LIST:
                $data = CHtml::listData($this->options, 'id', 'value');
                return CHtml::checkBoxList($name . '[]', $value, $data, $htmlOptions);
                break;
            case self::TYPE_CHECKBOX:
                return CHtml::checkBox($name, $value, CMap::mergeArray(['uncheckValue' => 0], $htmlOptions));
                break;
            case self::TYPE_NUMBER:
                return CHtml::numberField($name, $value, $htmlOptions);
                break;
            case self::TYPE_IMAGE:
                return CHtml::fileField($name, null, $htmlOptions);
                break;
        }

        return null;
    }

    public function renderValue($value)
    {
        $unit = $this->unit ? ' ' . $this->unit : '';
        $res = '';
        switch ($this->type) {
            case self::TYPE_TEXT:
            case self::TYPE_SHORT_TEXT:
            case self::TYPE_NUMBER:
                $res = $value;
                break;
            case self::TYPE_DROPDOWN:
                $data = CHtml::listData($this->options, 'id', 'value');
                if (!is_array($value) && isset($data[$value])) {
                    $res = $data[$value];
                }
                break;
            case self::TYPE_CHECKBOX:
                $res = $value ? Yii::t("StoreModule.store", "Yes") : Yii::t("StoreModule.store", "No");
                break;
        }

        return $res . $unit;
    }

    public function afterDelete()
    {
        /* удаляем привязанные к товару атрибуты */
        $this->getDbConnection()->createCommand("DELETE FROM {{store_product_attribute_eav}} WHERE `attribute`='{$this->name}'")->execute();

        parent::afterDelete();
    }

    /**
     * @return array
     */
    public static function getTypesWithOptions()
    {
        return [self::TYPE_DROPDOWN, self::TYPE_CHECKBOX_LIST];
    }

    public function getAttributeByName($name)
    {
        return $name ? self::model()->findByAttributes(['name' => $name]) : null;
    }

    public function getGroupTitle()
    {
        return $this->group instanceof AttributeGroup ? $this->group->name : '---';
    }

    public function afterFind()
    {
        $tmp = '';
        foreach ((array)$this->options as $option) {
            $tmp .= $option->value . "\n";
        }
        $this->rawOptions = $tmp;
    }

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

    public function isType($type)
    {
        return $type == $this->type;
    }

    public function isRequired()
    {
        return $this->required;
    }
}

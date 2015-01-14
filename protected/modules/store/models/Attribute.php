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
                'message' => Yii::t('StoreModule.store', 'Название может содержать только буквы, цифры и подчеркивания.')
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
            'name' => Yii::t('StoreModule.store', 'Идентификатор'),
            'title' => Yii::t('StoreModule.store', 'Название'),
            'type' => Yii::t('StoreModule.store', 'Тип'),
            'required' => Yii::t('StoreModule.store', 'Обязательный'),
            'group_id' => Yii::t('StoreModule.store', 'Группа'),
            'unit' => Yii::t('StoreModule.store', 'Единица измерения'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'name' => Yii::t('StoreModule.store', 'Идентификатор'),
            'title' => Yii::t('StoreModule.store', 'Название'),
            'type' => Yii::t('StoreModule.store', 'Тип'),
            'required' => Yii::t('StoreModule.store', 'Обязательный'),
            'group_id' => Yii::t('StoreModule.store', 'Группа'),
            'unit' => Yii::t('StoreModule.store', 'Единица измерения'),
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
            self::TYPE_SHORT_TEXT => Yii::t('StoreModule.store', 'Короткий текст (до 250 символов)'),
            self::TYPE_TEXT => Yii::t('StoreModule.store', 'Текст'),
            self::TYPE_DROPDOWN => Yii::t('StoreModule.store', 'Список'),
            //self::TYPE_CHECKBOX_LIST => Yii::t('StoreModule.store', 'Список чекбоксов'),
            self::TYPE_CHECKBOX => Yii::t('StoreModule.store', 'Чекбокс'),
            //self::TYPE_IMAGE => Yii::t('StoreModule.store', 'Изображение'),
            //self::TYPE_NUMBER => Yii::t('StoreModule.store', 'Число'),
        ];
    }

    public static function getTypeTitle($type)
    {
        $list = self::getTypesList();
        return $list[$type];
    }

    public function renderField($value = null, $name = null, $htmlOptions = ['class' => 'form-control'])
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
                return CHtml::checkBox($name, $value, $htmlOptions);
                break;
            case self::TYPE_NUMBER:
                return CHtml::numberField($name, $value, $htmlOptions);
                break;
            case self::TYPE_IMAGE:
                return CHtml::fileField($name, null, $htmlOptions);
                break;
        }
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
                $res = $value ? Yii::t("StoreModule.default", "Да") : Yii::t("StoreModule.default", "Нет");
                break;
        }
        return $res . $unit;
    }

    public function afterDelete()
    {
        $conn = $this->getDbConnection();
        /* удаляем привязанные к товару атрибуты */
        $command = $conn->createCommand("DELETE FROM {{store_product_attribute_eav}} WHERE `attribute`='{$this->name}'");
        $command->execute();

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
        // удаляем старые значения
        AttributeOption::model()->deleteAllByAttributes(['attribute_id' => $this->id]);

        if (in_array($this->type, [Attribute::TYPE_DROPDOWN])) {
            $newOptions = explode("\n", $this->rawOptions);
            $newOptions = array_filter(
                $newOptions,
                function ($x) {
                    return strlen(trim($x));
                }
            );

            foreach (array_values((array)$newOptions) as $key => $op) {
                $option = new AttributeOption();
                $option->attribute_id = $this->id;
                $option->value = trim($op);
                $option->position = $key;
                $option->save();
            }
        }

        parent::afterSave();
    }
}

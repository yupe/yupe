<?php

/**
 * This is the model class for table "Attribute".
 *
 * The followings are the available columns in table 'Category':
 * @property integer $id
 * @property string $name
 * @property string $title
 * @property integer $type
 * @property bool $required
 *
 * @property-read AttributeOption[] $options
 *
 */
class Attribute extends \yupe\models\YModel
{
    const TYPE_TEXT = 0;
    const TYPE_TEXTAREA = 1;
    const TYPE_DROPDOWN = 2;
    const TYPE_CHECKBOX = 3;
    const TYPE_CHECKBOX_LIST = 4;
    const TYPE_IMAGE = 5;
    const TYPE_NUMBER = 6;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_attribute}}';
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
            array('name, title', 'filter', 'filter' => 'trim'),
            array('name', 'required'),
            array('name', 'unique'),
            array('name', 'match',
                'pattern' => '/^([a-z0-9_])+$/i',
                'message' => Yii::t('ShopModule.attribute', 'Название может содержать только буквы, цифры и подчеркивания.')
            ),
            array('type', 'numerical', 'integerOnly' => true),
            array('required', 'boolean'),
            array('id, name, title, type, required', 'safe', 'on' => 'search'),
        );
    }


    public function relations()
    {
        return array(
            'options' => array(self::HAS_MANY, 'AttributeOption', 'attribute_id', 'order' => 'options.position ASC'),
        );
    }

    public function scopes()
    {

    }


    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('ShopModule.attribute', 'Id'),
            'name' => Yii::t('ShopModule.attribute', 'Идентификатор'),
            'title' => Yii::t('ShopModule.attribute', 'Название'),
            'type' => Yii::t('ShopModule.attribute', 'Тип'),
            'required' => Yii::t('ShopModule.attribute', 'Обязательный'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id' => Yii::t('ShopModule.attribute', 'Id'),
            'name' => Yii::t('ShopModule.attribute', 'Идентификатор'),
            'title' => Yii::t('ShopModule.attribute', 'Название'),
            'type' => Yii::t('ShopModule.attribute', 'Тип'),
            'required' => Yii::t('ShopModule.attribute', 'Обязательный'),
        );
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

        $sort             = new CSort;
        $sort->attributes = array(
            '*',
            'title' => array(
                'asc' => 'title',
                'desc' => 'title DESC',
            ),
        );

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => $sort
        ));
    }

    public static function getTypesList()
    {
        return array(
            self::TYPE_TEXT => Yii::t('ShopModule.attribute', 'Короткий текст (до 250 символов)'),
            self::TYPE_TEXTAREA => Yii::t('ShopModule.attribute', 'Текст'),
            self::TYPE_DROPDOWN => Yii::t('ShopModule.attribute', 'Список'),
            //self::TYPE_CHECKBOX_LIST => Yii::t('ShopModule.attribute', 'Список чекбоксов'),
            self::TYPE_CHECKBOX => Yii::t('ShopModule.attribute', 'Чекбокс'),
            //self::TYPE_IMAGE => Yii::t('ShopModule.attribute', 'Изображение'),
            //self::TYPE_NUMBER => Yii::t('ShopModule.attribute', 'Число'),
        );
    }

    public static function getTypeTitle($type)
    {
        $list = self::getTypesList();
        return $list[$type];
    }

    public function renderField($value = null, $name = null)
    {
        $name = $name ? : 'Attribute[' . $this->name . ']';
        switch ($this->type)
        {
            case self::TYPE_TEXT:
                return CHtml::textField($name, $value);
                break;
            case self::TYPE_TEXTAREA:
                $controller = new yupe\components\controllers\BackController('Attribute');
                return $controller->widget(Yii::app()->getModule('shop')->editor, array(
                    'name' => $name,
                    'value' => $value,
                    'options' => Yii::app()->getModule('shop')->editorOptions,
                ), true);
                break;
            case self::TYPE_DROPDOWN:
                $data = CHtml::listData($this->options, 'id', 'value');
                return CHtml::dropDownList($name, $value, $data, $this->required ? array() : array('empty' => '---'));
                break;
            case self::TYPE_CHECKBOX_LIST:
                $data = CHtml::listData($this->options, 'id', 'value');
                return CHtml::checkBoxList($name . '[]', $value, $data);
                break;
            case self::TYPE_CHECKBOX:
                return CHtml::checkBox($name, $value);
                break;
            case self::TYPE_NUMBER:
                return CHtml::numberField($name, $value);
                break;
            case self::TYPE_IMAGE:
                return CHtml::fileField($name);
                break;
        }
    }

    public function renderValue($value)
    {
        switch ($this->type)
        {
            case self::TYPE_TEXT:
            case self::TYPE_TEXTAREA:
            case self::TYPE_NUMBER:
                return $value;
                break;
            case self::TYPE_DROPDOWN:
                $data = CHtml::listData($this->options, 'id', 'value');
                if (!is_array($value) && isset($data[$value]))
                    return $data[$value];
                break;
            case self::TYPE_CHECKBOX:
                return $value ? Yii::t("ShopModule.default", "Да") : Yii::t("ShopModule.default", "Нет");
                break;
        }
    }

    public function afterDelete()
    {

        foreach ($this->options as $o)
        {
            $o->delete();
        }

        $conn    = $this->getDbConnection();
        $command = $conn->createCommand("DELETE FROM {{shop_good_attribute}} WHERE `attribute_id`='{$this->id}'");
        $command->execute();

        return parent::afterDelete();
    }

    /**
     * @return array
     */
    public static function getTypesWithOptions()
    {
        return array(self::TYPE_DROPDOWN, self::TYPE_CHECKBOX_LIST);
    }

    public function getAttributeByName($name)
    {
        return $name ? self::model()->findByAttributes(array('name' => $name)) : null;
    }
}
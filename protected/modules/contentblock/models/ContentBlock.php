<?php

/**
 * This is the model class for table "ContentBlock".
 *
 * The followings are the available columns in table 'ContentBlock':
 * @property string $id
 * @property string $name
 * @property integer $type
 * @property string $content
 * @property string $description
 */
class ContentBlock extends YModel
{
    const SIMPLE_TEXT = 1;
    const PHP_CODE    = 2;
    const HTML_TEXT   = 3;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return ContentBlock the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{contentblock_content_block}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, code, content, type', 'filter', 'filter' => 'trim'),
            array('name, code', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name, code, content, type', 'required'),
            array('type', 'numerical', 'integerOnly' => true),
            array('type', 'length', 'max' => 11),
            array('type', 'in', 'range' => array_keys($this->types)),
            array('name', 'length', 'max' => 250),
            array('code', 'length', 'max' => 100),
            array('description', 'length', 'max' => 255),
            array('code', 'YSLugValidator', 'message' => Yii::t('ContentBlockModule.contentblock', 'Неверный формат поля "{attribute}" допустимы только буквы, цифры и символ подчеркивания, от 2 до 50 символов')),
            array('code', 'unique'),
            array('id, name, code, type, content, description', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('ContentBlockModule.contentblock', 'id'),
            'name'        => Yii::t('ContentBlockModule.contentblock', 'Название'),
            'code'        => Yii::t('ContentBlockModule.contentblock', 'Символьный код'),
            'type'        => Yii::t('ContentBlockModule.contentblock', 'Тип'),
            'content'     => Yii::t('ContentBlockModule.contentblock', 'Контент'),
            'description' => Yii::t('ContentBlockModule.contentblock', 'Описание'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following name to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();
        $criteria->compare('name', $this->name);
        $criteria->compare('code', $this->code);
        $criteria->compare('type', $this->type);
        $criteria->compare('content', $this->content);
        $criteria->compare('description', $this->description);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getTypes()
    {
        return array(
            self::SIMPLE_TEXT => Yii::t('ContentBlockModule.contentblock', 'Простой текст'),
            self::PHP_CODE    => Yii::t('ContentBlockModule.contentblock', 'Исполняемый PHP код'),
            self::HTML_TEXT   => Yii::t('ContentBlockModule.contentblock', 'HTML код'),
        );
    }

    public function getType()
    {
        $data = $this->types;
        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('ContentBlockModule.contentblock', '*неизвестный тип*');
    }
}
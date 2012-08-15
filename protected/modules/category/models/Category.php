<?php

/**
 * This is the model class for table "Category".
 *
 * The followings are the available columns in table 'Category':
 * @property string $id
 * @property integer $parent_id
 * @property string $name
 * @property string $description
 * @property string $alias
 * @property integer $status
 */
class Category extends CActiveRecord
{

    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{category}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @return Category the static model class
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
            array('name, description, short_description, image, alias','filter', 'filter' => 'trim'),
            array('name, alias, image', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name, description, alias', 'required'),
            array('parent_id, status', 'numerical', 'integerOnly' => true),
            array('parent_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('name', 'length', 'max' => 150),
            array('alias', 'length', 'max' => 100),
            array('alias', 'match', 'pattern' => '/^[A-Za-z0-9\-]{1,50}$/', 'message' => Yii::t('category','Неверный формат поля "{attribute}" допустимы только буквы, цифры и символ "-", от 2 до 20 символов')),
            array('lang', 'length', 'max' => 2 ),
            array('lang', 'default', 'value' => Yii::app()->sourceLanguage),
            array('alias', 'unique', 'criteria' => array(
                'condition' => 'lang = :lang',
                'params' => array( ':lang' => $this->lang ) ),
                'on' => array( 'insert' ),
            ),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('image', 'file', 'types'=>'jpg, gif, png','allowEmpty' => true),
            array('id, parent_id, name, description, short_description, alias, status', 'safe', 'on' => 'search'),
        );
    }

    public function beforeValidate()
    {
        if(!$this->alias)
            $this->alias = YText::translit($this->name);

        return parent::beforeValidate();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('category', 'Id'),
            'lang' => Yii::t('category', 'Язык'),
            'parent_id' => Yii::t('category', 'Родитель'),
            'name' => Yii::t('category', 'Название'),
            'image' => Yii::t('category', 'Изображение'),
            'short_description' => Yii::t('category', 'Короткое описание'),
            'description' => Yii::t('category', 'Описание'),
            'alias' => Yii::t('category', 'Алиас'),
            'status' => Yii::t('category', 'Статус'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT      => Yii::t('category', 'Черновик'),
            self::STATUS_PUBLISHED  => Yii::t('category', 'Опубликовано'),
            self::STATUS_MODERATION => Yii::t('category', 'На модерации')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data)
            ? $data[$this->status]
            : Yii::t('category', '*неизвестно*');
    }

    public function getAllCategoryList($selfId = false)
    {
        $condition = '';
        $params = array();
        if($selfId)
        {
            $param = 'id != :id';
            $value = array(':id' => $selfId);
        }

        $category = $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll($condition, $params);
        $category = CHtml::listData($category, 'id', 'name');

        return $category;
    }

    public function getParentName()
    {
        if($this->parent_id)
        {
            $model = Category::model()->findByPk($this->parent_id);

            if($model)
                return $model->name;
        }

        return '---';
    }
}
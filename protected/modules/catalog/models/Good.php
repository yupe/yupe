<?php

/**
 * This is the model class for table "good".
 *
 * The followings are the available columns in table 'good':
 * @property string $id
 * @property string $category_id
 * @property string $name
 * @property double $price
 * @property string $article
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property string $alias
 * @property string $data
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $user_id
 * @property string $change_user_id
 *
 * The followings are the available model relations:
 * @property User $changeUser
 * @property Category $category
 * @property User $user
 */
class Good extends YModel
{
    const SPECIAL_NOT_ACTIVE = 0;
    const SPECIAL_ACTIVE     = 1;

    const STATUS_ZERO       = 0;
    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Good the static model class
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
        return '{{good}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, name, description, alias', 'required', 'except' => 'search'),
            array('name, description, short_description, image, alias, price, article, data, status, is_special', 'filter', 'filter' => 'trim'),
            array('name, alias, price, article, data, status, is_special', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('status, category_id, is_special', 'numerical', 'integerOnly' => true),
            array('price', 'numerical'),
            array('alias', 'unique'),
            array('name', 'length', 'max' => 150),
            array('article, alias', 'length', 'max' => 100),
            array('image', 'file', 'minSize' => $module->minSize, 'maxSize' => $module->maxSize, 'types' => $module->allowedExtensions, 'maxFiles' => $module->maxFiles, 'allowEmpty' => true),
            array('status','in','range' => array_keys($this->statusList)),
            array('is_special','in','range' => array(0, 1)),
            array('short_description, data', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, category_id, name, price, article, short_description, description, alias, data, status, create_time, update_time, user_id, change_user_id, is_special', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'changeUser' => array(self::BELONGS_TO, 'User', 'change_user_id'),
            'category'   => array(self::BELONGS_TO, 'Category', 'category_id'),
            'user'       => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_ACTIVE),
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('catalog', 'ID'),
            'category_id'       => Yii::t('catalog', 'Категория'),
            'name'              => Yii::t('catalog', 'Название'),
            'price'             => Yii::t('catalog', 'Цена'),
            'article'           => Yii::t('catalog', 'Артикул'),
            'image'             => Yii::t('catalog', 'Изображение'),
            'short_description' => Yii::t('catalog', 'Короткое описание'),
            'description'       => Yii::t('catalog', 'Описание'),
            'alias'             => Yii::t('catalog', 'Алиас'),
            'data'              => Yii::t('catalog', 'Данные'),
            'status'            => Yii::t('catalog', 'Статус'),
            'create_time'       => Yii::t('catalog', 'Добавлено'),
            'update_time'       => Yii::t('catalog', 'Изменено'),
            'user_id'           => Yii::t('catalog', 'Добавил'),
            'change_user_id'    => Yii::t('catalog', 'Изменил'),
            'is_special'        => Yii::t('catalog', 'Спецпредложение'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'                => Yii::t('catalog', 'ID'),
            'category_id'       => Yii::t('catalog', 'Категория'),
            'name'              => Yii::t('catalog', 'Название'),
            'price'             => Yii::t('catalog', 'Цена'),
            'article'           => Yii::t('catalog', 'Артикул'),
            'image'             => Yii::t('catalog', 'Изображение'),
            'short_description' => Yii::t('catalog', 'Короткое описание'),
            'description'       => Yii::t('catalog', 'Описание'),
            'alias'             => Yii::t('catalog', 'Алиас'),
            'data'              => Yii::t('catalog', 'Данные'),
            'status'            => Yii::t('catalog', 'Статус'),
            'create_time'       => Yii::t('catalog', 'Добавлено'),
            'update_time'       => Yii::t('catalog', 'Изменено'),
            'user_id'           => Yii::t('catalog', 'Добавил'),
            'change_user_id'    => Yii::t('catalog', 'Изменил'),
            'is_special'        => Yii::t('catalog', 'Спецпредложение'),
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
        $criteria->compare('category_id', $this->category_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('price', $this->price);
        $criteria->compare('article', $this->article, true);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('data', $this->data, true);
        $criteria->compare('is_special', $this->is_special, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('update_time', $this->update_time, true);
        $criteria->compare('user_id', $this->user_id,true);
        $criteria->compare('change_user_id', $this->change_user_id, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function behaviors()
    {
        return array('CTimestampBehavior' => array(
            'class'             => 'zii.behaviors.CTimestampBehavior',
            'setUpdateOnCreate' => true,
            'createAttribute'   => 'create_time',
            'updateAttribute'   => 'update_time',
        ));
    }

    /**
     * This is invoked after the record is deleted.
     */
    protected function afterDelete()
    {
        if(parent::afterDelete())
            @unlink($this->module->getUploadPath() . $this->image);
    }

    public function beforeValidate()
    {
        $this->change_user_id = Yii::app()->user->getId();

        if ($this->isNewRecord)
            $this->user_id = $this->change_user_id;

        if (!$this->alias)
            $this->alias = YText::translit($this->name);

        return parent::beforeValidate();
    }

    public function getPermaLink()
    {
        return Yii::app()->createAbsoluteUrl('/catalog/catalog/show/', array( 'name' => $this->alias ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ZERO       => Yii::t('catalog', 'Нет в наличии'),
            self::STATUS_ACTIVE     => Yii::t('catalog', 'Доступен'),
            self::STATUS_NOT_ACTIVE => Yii::t('catalog', 'Не доступен'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('catalog', '*неизвестно*'); 
    }

    public function getSpecialList()
    {
        return array(
            self::SPECIAL_NOT_ACTIVE => Yii::t('catalog', 'Нет'),
            self::STATUS_ACTIVE      => Yii::t('catalog', 'Да'),
        );
    }

    public function getSpecial()
    {
        $data = $this->specialList;
        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t('catalog', '*неизвестно*'); 
    }

    public function getImageUrl()
    {
        return ($this->image)
            ? Yii::app()->baseUrl . '/' .
              Yii::app()->getModule('yupe')->uploadPath . '/' .
              Yii::app()->getModule('catalog')->uploadPath . '/' .
              $this->image
            : false;
    }
}
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
 * @property string $lang
 */
class Category extends YModel
{

    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{category_category}}';
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
            array('name, description, short_description, alias', 'filter', 'filter' => 'trim'),
            array('name, alias', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name, description, alias, lang', 'required'),
            array('parent_id, status', 'numerical', 'integerOnly' => true),
            array('parent_id, status', 'length', 'max' => 11),
            array('parent_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('name, image', 'length', 'max' => 250),
            array('alias', 'length', 'max' => 150),
            array('lang', 'length', 'max' => 2 ),
            array('alias', 'YSLugValidator', 'message' => Yii::t('catalog', 'Запрещенные символы в поле {attribute}')),
            array('alias', 'YUniqueSlugValidator'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('id, parent_id, name, description, short_description, alias, status, lang', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('category');
        return array(
            'imageUpload' => array(
                'class'         =>'application.modules.yupe.models.ImageUploadBehavior',
                'scenarios'     => array('insert','update'),
                'attributeName' => 'image',
                'uploadPath'    => $module !== null ? $module->getUploadPath() : null,
                'imageNameCallback' => array($this, 'generateFileName'),
                'resize' => array(
                    'quality' => 70,
                    'width' => 800,
                )
            ),
        );
    }

    public function generateFileName()
    {
        return md5($this->name . time());
    }

    public function beforeValidate()
    {
        if (!$this->alias)
            $this->alias = YText::translit($this->name);

        if(!$this->lang)
            $this->lang = Yii::app()->language;

        return parent::beforeValidate();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('CategoryModule.category', 'Id'),
            'lang'              => Yii::t('CategoryModule.category', 'Язык'),
            'parent_id'         => Yii::t('CategoryModule.category', 'Родитель'),
            'name'              => Yii::t('CategoryModule.category', 'Название'),
            'image'             => Yii::t('CategoryModule.category', 'Изображение'),
            'short_description' => Yii::t('CategoryModule.category', 'Короткое описание'),
            'description'       => Yii::t('CategoryModule.category', 'Описание'),
            'alias'             => Yii::t('CategoryModule.category', 'Алиас'),
            'status'            => Yii::t('CategoryModule.category', 'Статус'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
       return array(
            'id'                => Yii::t('CategoryModule.category', 'Id'),
            'lang'              => Yii::t('CategoryModule.category', 'Язык'),
            'parent_id'         => Yii::t('CategoryModule.category', 'Родитель'),
            'name'              => Yii::t('CategoryModule.category', 'Название'),
            'image'             => Yii::t('CategoryModule.category', 'Изображение'),
            'short_description' => Yii::t('CategoryModule.category', 'Короткое описание'),
            'description'       => Yii::t('CategoryModule.category', 'Описание'),
            'alias'             => Yii::t('CategoryModule.category', 'Алиас'),
            'status'            => Yii::t('CategoryModule.category', 'Статус'),
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
        $criteria->compare('parent_id', $this->parent_id,true);
        $criteria->compare('name', $this->name);
        $criteria->compare('description', $this->description);
        $criteria->compare('alias', $this->alias);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT      => Yii::t('CategoryModule.category', 'Черновик'),
            self::STATUS_PUBLISHED  => Yii::t('CategoryModule.category', 'Опубликовано'),
            self::STATUS_MODERATION => Yii::t('CategoryModule.category', 'На модерации'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('CategoryModule.category', '*неизвестно*');
    }

    public function getAllCategoryList($selfId = false)
    {
        $conditionArray = ($selfId) 
            ? array('condition' => 'id != :id', 'params' => array(':id' => $selfId))
            : array();

        $category = $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll($conditionArray);

        return CHtml::listData($category, 'id', 'name');
    }

    public function getParentName()
    {
        if ($this->parent_id)
        {
            $model = Category::model()->findByPk($this->parent_id);

            if ($model)
                return $model->name;
        }
        return '---';
    }

    public function getImageSrc()
    {
        return Yii::app()->baseUrl . "/" .
               Yii::app()->getModule("yupe")->uploadPath . "/" .
               Yii::app()->getModule("category")->uploadPath . "/" .
               $this->image;
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_PUBLISHED),
            ),
        );
    }
}
<?php

/**
 * Модель Category
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.category.models
 * @since 0.1
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property integer $status
 * @property string $lang
 * @property integer $parent_id
 *
 * @property-read Category $parent
 * @property-read Category[] $children
 *
 * @method Category published()
 * @method Category roots()
 */

use yupe\components\Event;
use yupe\widgets\YPurifier;

class Category extends yupe\models\YModel
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
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
        return [
            ['name, description, short_description, slug', 'filter', 'filter' => 'trim'],
            ['name, slug', 'filter', 'filter' => [new YPurifier(), 'purify']],
            ['name, slug, lang', 'required'],
            ['parent_id, status', 'numerical', 'integerOnly' => true],
            ['parent_id, status', 'length', 'max' => 11],
            ['parent_id', 'default', 'setOnEmpty' => true, 'value' => null],
            ['status', 'numerical', 'integerOnly' => true],
            ['status', 'length', 'max' => 11],
            ['name, image', 'length', 'max' => 250],
            ['slug', 'length', 'max' => 150],
            ['lang', 'length', 'max' => 2],
            [
                'slug',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('CategoryModule.category', 'Bad characters in {attribute} field')
            ],
            ['slug', 'yupe\components\validators\YUniqueSlugValidator'],
            ['status', 'in', 'range' => array_keys($this->statusList)],
            ['id, parent_id, name, description, short_description, slug, status, lang', 'safe', 'on' => 'search'],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('category');

        return [
            'imageUpload' => [
                'class' => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'uploadPath' => $module->uploadPath,
            ],
        ];
    }

    public function relations()
    {
        return [
            'parent' => [self::BELONGS_TO, 'Category', 'parent_id'],
            'children' => [self::HAS_MANY, 'Category', 'parent_id'],
        ];
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 'status = :status',
                'params' => [':status' => self::STATUS_PUBLISHED],
            ],
            'roots' => [
                'condition' => 'parent_id IS NULL',
            ],
        ];
    }

    public function beforeValidate()
    {
        if (!$this->slug) {
            $this->slug = yupe\helpers\YText::translit($this->name);
        }

        if (!$this->lang) {
            $this->lang = Yii::app()->language;
        }

        return parent::beforeValidate();
    }

    /**
     *
     */
    public function afterSave()
    {
        Yii::app()->eventManager->fire(CategoryEvents::CATEGORY_AFTER_SAVE, new Event($this));

        return parent::afterSave();
    }

    /**
     *
     */
    public function afterDelete()
    {
        Yii::app()->eventManager->fire(CategoryEvents::CATEGORY_AFTER_DELETE, new Event($this));

        parent::afterDelete();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('CategoryModule.category', 'Id'),
            'lang' => Yii::t('CategoryModule.category', 'Language'),
            'parent_id' => Yii::t('CategoryModule.category', 'Parent'),
            'name' => Yii::t('CategoryModule.category', 'Title'),
            'image' => Yii::t('CategoryModule.category', 'Image'),
            'short_description' => Yii::t('CategoryModule.category', 'Short description'),
            'description' => Yii::t('CategoryModule.category', 'Description'),
            'slug' => Yii::t('CategoryModule.category', 'Alias'),
            'status' => Yii::t('CategoryModule.category', 'Status'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('CategoryModule.category', 'Id'),
            'lang' => Yii::t('CategoryModule.category', 'Language'),
            'parent_id' => Yii::t('CategoryModule.category', 'Parent'),
            'name' => Yii::t('CategoryModule.category', 'Title'),
            'image' => Yii::t('CategoryModule.category', 'Image'),
            'short_description' => Yii::t('CategoryModule.category', 'Short description'),
            'description' => Yii::t('CategoryModule.category', 'Description'),
            'slug' => Yii::t('CategoryModule.category', 'Alias'),
            'status' => Yii::t('CategoryModule.category', 'Status'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }

    /**
     * Returns available status list
     *
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT => Yii::t('CategoryModule.category', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('CategoryModule.category', 'Published'),
            self::STATUS_MODERATION => Yii::t('CategoryModule.category', 'On moderation'),
        ];
    }

    /**
     * Returns current status name
     *
     * @return string
     */
    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('CategoryModule.category', '*unknown*');
    }

    /**
     * Returns parent category name
     *
     * @param string $empty Text shown if the category have no parent. Default: ---
     * @return string
     */
    public function getParentName($empty = '---')
    {
        return isset($this->parent) ? $this->parent->name : $empty;
    }
}

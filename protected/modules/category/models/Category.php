<?php

/**
 * Модель Category
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.category.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "Category".
 *
 * The followings are the available columns in table 'Category':
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
            ['name, slug', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
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
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'uploadPath'    => $module->uploadPath,
            ],
        ];
    }

    public function relations()
    {
        return [
            'parent'   => [self::BELONGS_TO, 'Category', 'parent_id'],
            'children' => [self::HAS_MANY, 'Category', 'parent_id'],
        ];
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 'status = :status',
                'params'    => [':status' => self::STATUS_PUBLISHED],
            ],
            'roots'     => [
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
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('CategoryModule.category', 'Id'),
            'lang'              => Yii::t('CategoryModule.category', 'Language'),
            'parent_id'         => Yii::t('CategoryModule.category', 'Parent'),
            'name'              => Yii::t('CategoryModule.category', 'Title'),
            'image'             => Yii::t('CategoryModule.category', 'Image'),
            'short_description' => Yii::t('CategoryModule.category', 'Short description'),
            'description'       => Yii::t('CategoryModule.category', 'Description'),
            'slug'             => Yii::t('CategoryModule.category', 'Alias'),
            'status'            => Yii::t('CategoryModule.category', 'Status'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id'                => Yii::t('CategoryModule.category', 'Id'),
            'lang'              => Yii::t('CategoryModule.category', 'Language'),
            'parent_id'         => Yii::t('CategoryModule.category', 'Parent'),
            'name'              => Yii::t('CategoryModule.category', 'Title'),
            'image'             => Yii::t('CategoryModule.category', 'Image'),
            'short_description' => Yii::t('CategoryModule.category', 'Short description'),
            'description'       => Yii::t('CategoryModule.category', 'Description'),
            'slug'             => Yii::t('CategoryModule.category', 'Alias'),
            'status'            => Yii::t('CategoryModule.category', 'Status'),
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

    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT      => Yii::t('CategoryModule.category', 'Draft'),
            self::STATUS_PUBLISHED  => Yii::t('CategoryModule.category', 'Published'),
            self::STATUS_MODERATION => Yii::t('CategoryModule.category', 'On moderation'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('CategoryModule.category', '*unknown*');
    }

    public function getAllCategoryList($selfId = false)
    {
        $conditionArray = ($selfId)
            ? ['condition' => 'id != :id', 'params' => [':id' => $selfId]]
            : [];

        $category = $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll($conditionArray);

        return CHtml::listData($category, 'id', 'name');
    }

    public function getDescendants($parent = null)
    {
        $out = [];

        $parent = $parent === null ? (int)$this->id : (int)$parent;

        $models = self::findAll(
            'parent_id = :id',
            [
                ':id' => $parent
            ]
        );

        foreach ($models as $model) {
            $out[] = $model;
            $out = CMap::mergeArray($out, $model->getDescendants((int)$model->id));
        }

        return $out;
    }

    /**
     * Возвращает отформатированный список в соответствии со вложенность категорий.
     *
     * @param null|int $parentId
     * @param int $level
     * @param null|array|CDbCriteria $criteria
     * @return array
     */
    public function getFormattedList($parentId = null, $level = 0, $criteria = null)
    {
        if (empty($parentId)) {
            $parentId = null;
        }

        $categories = Category::model()->findAllByAttributes(['parent_id' => $parentId], $criteria);

        $list = [];

        foreach ($categories as $category) {

            $category->name = str_repeat('&emsp;', $level) . $category->name;

            $list[$category->id] = $category->name;

            $list = CMap::mergeArray($list, $this->getFormattedList($category->id, $level + 1, $criteria));
        }

        return $list;
    }

    public function getParentName()
    {
        if ($model = $this->parent) {
            return $model->name;
        }

        return '---';
    }

    public function getByAlias($slug)
    {
        return self::model()->published()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->find(
            'slug = :slug',
            [
                ':slug' => $slug
            ]
        );
    }

    public function getById($id)
    {
        return self::model()->published()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findByPk((int)$id);
    }
}

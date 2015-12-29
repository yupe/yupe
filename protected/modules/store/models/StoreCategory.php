<?php
use yupe\components\Event;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $slug
 * @property integer $status
 * @property integer $parent_id
 * @property integer $sort
 * @property integer $external_id
 *
 * @property-read StoreCategory $parent
 * @property-read StoreCategory[] $children
 *
 * @method StoreCategory published()
 * @method StoreCategory roots()
 * @method getImageUrl($width = 0, $height = 0, $crop = true, $defaultImage = null)
 *
 */
class StoreCategory extends \yupe\models\YModel
{
    /**
     *
     */
    const STATUS_DRAFT = 0;
    /**
     *
     */
    const STATUS_PUBLISHED = 1;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_category}}';
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return StoreCategory the static model class
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
        return [
            [
                'name, description, short_description, slug, meta_title, meta_keywords, meta_description',
                'filter',
                'filter' => 'trim',
            ],
            ['name, slug', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['name, slug', 'required'],
            ['parent_id, status, sort, external_id', 'numerical', 'integerOnly' => true],
            ['parent_id, status', 'length', 'max' => 11],
            ['parent_id', 'default', 'setOnEmpty' => true, 'value' => null],
            ['status', 'numerical', 'integerOnly' => true],
            ['status', 'length', 'max' => 11],
            ['name, image, meta_title, meta_keywords, meta_description', 'length', 'max' => 250],
            ['slug', 'length', 'max' => 150],
            [
                'slug',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('StoreModule.store', 'Bad characters in {attribute} field'),
            ],
            ['slug', 'unique'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['id, parent_id, name, description, sort, short_description, slug, status', 'safe', 'on' => 'search'],
        ];
    }


    /**
     * @return array
     */
    public function behaviors()
    {
        $module = Yii::app()->getModule('store');

        return [
            'imageUpload' => [
                'class' => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'minSize' => $module->minSize,
                'maxSize' => $module->maxSize,
                'types' => $module->allowedExtensions,
                'uploadPath' => $module !== null ? $module->uploadPath.'/category' : null,
            ],
            'tree' => [
                'class' => 'store\components\behaviors\DCategoryTreeBehavior',
                'aliasAttribute' => 'slug',
                'requestPathAttribute' => 'path',
                'parentAttribute' => 'parent_id',
                'parentRelation' => 'parent',
                'defaultCriteria' => [
                    'order' => 't.sort',
                ],
                'titleAttribute' => 'name',
                'useCache' => true,
            ],
            'sortable' => [
                'class' => 'yupe\components\behaviors\SortableBehavior',
                'attributeName' => 'sort',
            ],
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'parent' => [self::BELONGS_TO, 'StoreCategory', 'parent_id'],
            'children' => [self::HAS_MANY, 'StoreCategory', 'parent_id'],
            'productCount' => [self::STAT, 'Product', 'category_id'],
        ];
    }

    /**
     * @return array
     */
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


    /**
     *
     */
    public function afterSave()
    {
        Yii::app()->eventManager->fire(StoreEvents::CATEGORY_AFTER_SAVE, new Event($this));

        return parent::afterSave();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'parent_id' => Yii::t('StoreModule.store', 'Parent'),
            'name' => Yii::t('StoreModule.store', 'Name'),
            'image' => Yii::t('StoreModule.store', 'Image'),
            'short_description' => Yii::t('StoreModule.store', 'Short description'),
            'description' => Yii::t('StoreModule.store', 'Description'),
            'slug' => Yii::t('StoreModule.store', 'Alias'),
            'meta_title' => Yii::t('StoreModule.store', 'Meta title'),
            'meta_keywords' => Yii::t('StoreModule.store', 'Meta keywords'),
            'meta_description' => Yii::t('StoreModule.store', 'Meta description'),
            'status' => Yii::t('StoreModule.store', 'Status'),
            'sort' => Yii::t('StoreModule.store', 'Order'),
            'external_id' => Yii::t('StoreModule.store', 'External id'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'Id'),
            'parent_id' => Yii::t('StoreModule.store', 'Parent'),
            'name' => Yii::t('StoreModule.store', 'Title'),
            'image' => Yii::t('StoreModule.store', 'Image'),
            'short_description' => Yii::t('StoreModule.store', 'Short description'),
            'description' => Yii::t('StoreModule.store', 'Description'),
            'slug' => Yii::t('StoreModule.store', 'Alias'),
            'meta_title' => Yii::t('StoreModule.store', 'Meta title'),
            'meta_keywords' => Yii::t('StoreModule.store', 'Meta keywords'),
            'meta_description' => Yii::t('StoreModule.store', 'Meta description'),
            'status' => Yii::t('StoreModule.store', 'Status'),
            'sort' => Yii::t('StoreModule.store', 'Order'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('meta_title', $this->meta_title, true);
        $criteria->compare('meta_keywords', $this->meta_keywords, true);
        $criteria->compare('meta_description', $this->meta_description, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);

        return new CActiveDataProvider(
            StoreCategory::_CLASS_(),
            [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.sort'],
            ]
        );
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT => Yii::t('StoreModule.store', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('StoreModule.store', 'Published'),
        ];
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('StoreModule.store', '*unknown*');
    }

    /**
     * @return string
     */
    public function getParentName()
    {
        return $this->parent ? $this->parent->name : '---';
    }

    /**
     * @return string
     */
    public function getMetaTile()
    {
        return $this->meta_title ?: $this->name;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->meta_description;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }
}

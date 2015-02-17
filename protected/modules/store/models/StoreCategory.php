<?php

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $alias
 * @property integer $status
 * @property integer $parent_id
 * @property integer $sort
 *
 * @property-read StoreCategory $parent
 * @property-read StoreCategory[] $children
 *
 * @method StoreCategory published()
 * @method StoreCategory roots()
 * @method getImageUrl($width = 0, $height = 0, $adaptiveResize = true)
 *
 */
class StoreCategory extends \yupe\models\YModel
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;


    private $_url;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_category}}';
    }

    /**
     * Returns the static model of the specified AR class.
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
            ['name, description, short_description, alias, meta_title, meta_keywords, meta_description', 'filter', 'filter' => 'trim'],
            ['name, alias', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['name, alias', 'required'],
            ['parent_id, status, sort', 'numerical', 'integerOnly' => true],
            ['parent_id, status', 'length', 'max' => 11],
            ['parent_id', 'default', 'setOnEmpty' => true, 'value' => null],
            ['status', 'numerical', 'integerOnly' => true],
            ['status', 'length', 'max' => 11],
            ['name, image, meta_title, meta_keywords, meta_description', 'length', 'max' => 250],
            ['alias', 'length', 'max' => 150],
            ['alias', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('StoreModule.store', 'Запрещенные символы в поле {attribute}')],
            ['alias', 'unique'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            ['id, parent_id, name, description, sort, short_description, alias, status', 'safe', 'on' => 'search'],
        ];
    }


    public function behaviors()
    {
        $module = Yii::app()->getModule('store');

        return [
            'imageUpload' => [
                'class' => 'yupe\components\behaviors\ImageUploadBehavior',
                'scenarios' => ['insert', 'update'],
                'attributeName' => 'image',
                'minSize' => $module->minSize,
                'maxSize' => $module->maxSize,
                'types' => $module->allowedExtensions,
                'uploadPath' => $module !== null ? $module->uploadPath . '/category' : null,
            ],
            'CategoryTreeBehavior' => [
                'class' => 'store\components\behaviors\DCategoryTreeBehavior',
                'titleAttribute' => 'name',
                'aliasAttribute' => 'alias',
                'urlAttribute' => 'url',
                'requestPathAttribute' => 'path',
                'parentAttribute' => 'parent_id',
                'parentRelation' => 'parent',
                'defaultCriteria' => [
                    'condition' => 'status = :status',
                    'params' => [':status' => self::STATUS_PUBLISHED],
                    'order' => 't.name ASC'
                ],
                'useCache' => true,
            ],
        ];
    }

    public function generateFileName()
    {
        return md5($this->name . time());
    }

    public function relations()
    {
        return [
            'parent' => [self::BELONGS_TO, 'StoreCategory', 'parent_id'],
            'children' => [self::HAS_MANY, 'StoreCategory', 'parent_id'],
            'productCount' => [self::STAT, 'Product', 'category_id']
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
        if (!$this->alias) {
            $this->alias = yupe\helpers\YText::translit($this->name);
        }

        return parent::beforeValidate();
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
            'alias' => Yii::t('StoreModule.store', 'Alias'),
            'meta_title' => Yii::t('StoreModule.store', 'Meta title'),
            'meta_keywords' => Yii::t('StoreModule.store', 'Meta keywords'),
            'meta_description' => Yii::t('StoreModule.store', 'Meta description'),
            'status' => Yii::t('StoreModule.store', 'Status'),
            'sort' => Yii::t('StoreModule.store', 'Order'),
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
            'alias' => Yii::t('StoreModule.store', 'Alias'),
            'meta_title' => Yii::t('StoreModule.store', 'Meta title'),
            'meta_keywords' => Yii::t('StoreModule.store', 'Meta keywords'),
            'meta_description' => Yii::t('StoreModule.store', 'Meta description'),
            'status' => Yii::t('StoreModule.store', 'Status'),
            'sort' => Yii::t('StoreModule.store', 'Order'),
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('parent_id', $this->parent_id);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('alias', $this->alias, true);
        $criteria->compare('meta_title', $this->alias, true);
        $criteria->compare('meta_keywords', $this->alias, true);
        $criteria->compare('meta_description', $this->alias, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->status);

        return new CActiveDataProvider(
            get_class($this),
            [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 't.sort']
            ]
        );
    }

    public function getStatusList()
    {
        return [
            self::STATUS_DRAFT => Yii::t('StoreModule.store', 'Draft'),
            self::STATUS_PUBLISHED => Yii::t('StoreModule.store', 'Published')
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('StoreModule.store', '*unknown*');
    }

    public function getAllCategoryList($selfId = false)
    {
        $conditionArray = ($selfId)
            ? ['condition' => 'id != :id', 'params' => [':id' => $selfId]]
            : [];

        $category = $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll($conditionArray);

        return CHtml::listData($category, 'id', 'name');
    }

    public function getFormattedList($parent_id = null, $level = 0)
    {
        $categories = StoreCategory::model()->findAllByAttributes(['parent_id' => $parent_id]);

        $list = [];

        foreach ($categories as $key => $category) {

            $category->name = str_repeat('&emsp;', $level) . $category->name;

            $list[$category->id] = $category->name;

            $list = CMap::mergeArray($list, $this->getFormattedList($category->id, $level + 1));
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

    public function getByAlias($alias)
    {
        return self::model()->published()->find(
            'alias = :alias',
            [
                ':alias' => $alias
            ]
        );
    }

    public function getUrl()
    {
        if ($this->_url === null) {
            $this->_url = Yii::app()->getRequest()->baseUrl . '/store/' . $this->getPath() . Yii::app()->getUrlManager()->urlSuffix;
        }
        return $this->_url;
    }

    public function getMetaTile()
    {
        return $this->meta_title ?: $this->name;
    }

    public function getMetaDescription()
    {
        return $this->description;
    }

    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }


    /**
     * Сортировака пунктов меню
     * @param array $items
     * @return bool
     */
    public function sort(array $items)
    {
        $transaction = Yii::app()->db->beginTransaction();
        try {
            foreach ($items as $id => $priority) {
                $model = $this->findByPk($id);
                if (null === $model) {
                    continue;
                }
                $model->sort = (int)$priority;
                if (!$model->update('sort')) {
                    throw new CDbException('Error sort menu items!');
                }
            }
            $transaction->commit();
            return true;
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }
    }


    public function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $position = Yii::app()->getDb()->createCommand("select max(sort) from {$this->tableName()}")->queryScalar();
            $this->sort = (int)$position + 1;
        }

        return parent::beforeSave();
    }


}

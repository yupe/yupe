<?php

/**
 * This is the model class for table "Category".
 *
 * The followings are the available columns in table 'Category':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $alias
 * @property integer $status
 * @property integer $parent_id
 *
 * @property-read Category $parent
 * @property-read Category[] $children
 *
 * @method Category published()
 * @method Category roots()
 */
class Category extends \yupe\models\YModel
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;
    const STATUS_MODERATION = 2;

    private $_url;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_category}}';
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
            array('name, description, short_description, alias, meta_title, meta_keywords, meta_description', 'filter', 'filter' => 'trim'),
            array('name, alias', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('name, alias', 'required'),
            array('parent_id, status', 'numerical', 'integerOnly' => true),
            array('parent_id, status', 'length', 'max' => 11),
            array('parent_id', 'default', 'setOnEmpty' => true, 'value' => null),
            array('status', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 11),
            array('name, image, meta_title, meta_keywords, meta_description', 'length', 'max' => 250),
            array('alias', 'length', 'max' => 150),
            array('alias', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('ShopModule.category', 'Запрещенные символы в поле {attribute}')),
            array('alias', 'unique'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('id, parent_id, name, description, short_description, alias, status', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('shop');

        return array(
            'imageUpload' => array(
                'class'         =>'yupe\components\behaviors\FileUploadBehavior',
                'scenarios'     => array('insert','update'),
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module !== null ? $module->uploadPath . '/category' : null,
            ),
            'imageThumb'  => array(
                'class'         => 'yupe\components\behaviors\ImageThumbBehavior',
                'uploadPath'    => $module->uploadPath . '/category',
                'attributeName' => 'image',
            ),
            'CategoryTreeBehavior'=>array(
                'class'=>'shop\components\behaviors\DCategoryTreeBehavior',
                'titleAttribute'=>'name',
                'aliasAttribute'=>'alias',
                'urlAttribute'=>'url',
                'requestPathAttribute'=>'path',
                'parentAttribute'=>'parent_id',
                'parentRelation'=>'parent',
                'defaultCriteria'=>array(
                    'order'=>'t.name ASC'
                ),
            ),
        );
    }

    public function generateFileName()
    {
        return md5($this->name . time());
    }

    public function relations()
    {
        return array(
            'parent'   => array(self::BELONGS_TO, 'Category', 'parent_id'),
            'children' => array(self::HAS_MANY, 'Category', 'parent_id'),
        );
    }

    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_PUBLISHED),
            ),
            'roots'     => array(
                'condition' => 'parent_id IS NULL',
            ),
        );
    }

    public function beforeValidate()
    {
        if (!$this->alias)
        {
            $this->alias = yupe\helpers\YText::translit($this->name);
        }

        return parent::beforeValidate();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('ShopModule.category', 'Id'),
            'parent_id'         => Yii::t('ShopModule.category', 'Parent'),
            'name'              => Yii::t('ShopModule.category', 'Name'),
            'image'             => Yii::t('ShopModule.category', 'Image'),
            'short_description' => Yii::t('ShopModule.category', 'Short description'),
            'description'       => Yii::t('ShopModule.category', 'Description'),
            'alias'             => Yii::t('ShopModule.category', 'Alias'),
            'meta_title'        => Yii::t('ShopModule.category', 'Meta Title'),
            'meta_keywords'     => Yii::t('ShopModule.category', 'Meta Keywords'),
            'meta_description'  => Yii::t('ShopModule.category', 'Meta Description'),
            'status'            => Yii::t('ShopModule.category', 'Status'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return array(
            'id'                => Yii::t('ShopModule.category', 'Id'),
            'parent_id'         => Yii::t('ShopModule.category', 'Parent'),
            'name'              => Yii::t('ShopModule.category', 'Title'),
            'image'             => Yii::t('ShopModule.category', 'Image'),
            'short_description' => Yii::t('ShopModule.category', 'Short description'),
            'description'       => Yii::t('ShopModule.category', 'Description'),
            'alias'             => Yii::t('ShopModule.category', 'Alias'),
            'meta_title'        => Yii::t('ShopModule.category', 'Meta Title'),
            'meta_keywords'     => Yii::t('ShopModule.category', 'Meta Keywords'),
            'meta_description'  => Yii::t('ShopModule.category', 'Meta Description'),
            'status'            => Yii::t('ShopModule.category', 'Status'),
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
        $criteria->compare('meta_title', $this->alias, true);
        $criteria->compare('meta_keywords', $this->alias, true);
        $criteria->compare('meta_description', $this->alias, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT      => Yii::t('ShopModule.category', 'Draft'),
            self::STATUS_PUBLISHED  => Yii::t('ShopModule.category', 'Published'),
            self::STATUS_MODERATION => Yii::t('ShopModule.category', 'On moderation'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('ShopModule.category', '*unknown*');
    }

    public function getAllCategoryList($selfId = false)
    {
        $conditionArray = ($selfId)
            ? array('condition' => 'id != :id', 'params' => array(':id' => $selfId))
            : array();

        $category = $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll($conditionArray);

        return CHtml::listData($category, 'id', 'name');
    }

    public function getFormattedList($parent_id = null, $level = 0)
    {
        $categories = Category::model()->findAllByAttributes(array('parent_id' => $parent_id));

        $list = array();

        foreach ($categories as $key => $category)
        {

            $category->name = str_repeat('&emsp;', $level) . $category->name;

            $list[$category->id] = $category->name;

            $list = CMap::mergeArray($list, $this->getFormattedList($category->id, $level + 1));
        }

        return $list;
    }

    public function getParentName()
    {
        if ($model = $this->parent)
        {
            return $model->name;
        }

        return '---';
    }

    public function getByAlias($alias)
    {
        return self::model()->published()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->find(
            'alias = :alias',
            array(
                ':alias' => $alias
            )
        );
    }


    public function getUrl()
    {
        if ($this->_url === null)
            $this->_url = Yii::app()->request->baseUrl . '/catalog/' .  $this->cache(3600)->getPath() . Yii::app()->urlManager->urlSuffix;
        return $this->_url;
    }
}
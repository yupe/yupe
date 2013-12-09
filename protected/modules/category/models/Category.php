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
 * @property string $alias
 * @property integer $status
 * @property string $lang
 *
 * @method Category roots()
 * @method Category descendants()
 * @method Category children()
 * @method Category ancestors()
 * @method Category parent()
 * @method bool saveNode()
 * @method bool deleteNode()
 * @method bool appendTo()
 * @method bool prependTo()
 */
class Category extends YModel
{
    const STATUS_DRAFT      = 0;
    const STATUS_PUBLISHED  = 1;
    const STATUS_MODERATION = 2;

	public $parent_id;

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
            array('status', 'numerical', 'integerOnly' => true),
            array('status', 'length', 'max' => 11),
            array('name, image', 'length', 'max' => 250),
            array('alias', 'length', 'max' => 150),
            array('lang', 'length', 'max' => 2 ),
            array('alias', 'YSLugValidator', 'message' => Yii::t('CategoryModule.category', 'Bad characters in {attribute} field')),
            array('alias', 'YUniqueSlugValidator'),
            array('status', 'in', 'range' => array_keys($this->statusList)),
			array('parent_id', 'safe'),
            array('id, name, description, short_description, alias, status, lang', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('category');
        return array(
			'NestedSetBehavior'=>array(
				'class' => 'vendor.yiiext.nested-set-behavior.NestedSetBehavior',
				'hasManyRoots' => true,
			),
            'imageUpload' => array(
                'class'         =>'application.modules.yupe.components.behaviors.ImageUploadBehavior',
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
            'lang'              => Yii::t('CategoryModule.category', 'Language'),
            'parent_id'         => Yii::t('CategoryModule.category', 'Parent'),
            'name'              => Yii::t('CategoryModule.category', 'Title'),
            'image'             => Yii::t('CategoryModule.category', 'Image'),
            'short_description' => Yii::t('CategoryModule.category', 'Short description'),
            'description'       => Yii::t('CategoryModule.category', 'Description'),
            'alias'             => Yii::t('CategoryModule.category', 'Alias'),
            'status'            => Yii::t('CategoryModule.category', 'Status'),
        );
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
       return array(
            'id'                => Yii::t('CategoryModule.category', 'Id'),
            'lang'              => Yii::t('CategoryModule.category', 'Language'),
            'parent_id'         => Yii::t('CategoryModule.category', 'Parent'),
            'name'              => Yii::t('CategoryModule.category', 'Title'),
            'image'             => Yii::t('CategoryModule.category', 'Image'),
            'short_description' => Yii::t('CategoryModule.category', 'Short description'),
            'description'       => Yii::t('CategoryModule.category', 'Description'),
            'alias'             => Yii::t('CategoryModule.category', 'Alias'),
            'status'            => Yii::t('CategoryModule.category', 'Status'),
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
        $criteria->compare('name', $this->name);
        $criteria->compare('description', $this->description);
        $criteria->compare('alias', $this->alias);
        $criteria->compare('lang', $this->lang);
        $criteria->compare('status', $this->status);

		$class = ($this->parent_id) ? Category::model()->findByPk($this->parent_id)->children() : get_class($this);

        return new CActiveDataProvider($class, array('criteria' => $criteria));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_DRAFT      => Yii::t('CategoryModule.category', 'Draft'),
            self::STATUS_PUBLISHED  => Yii::t('CategoryModule.category', 'Published'),
            self::STATUS_MODERATION => Yii::t('CategoryModule.category', 'On moderation'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('CategoryModule.category', '*unknown*');
    }

    public function getAllCategoryList($selfId = false)
    {
        $conditionArray = ($selfId)
            ? array('condition' => 'id != :id', 'params' => array(':id' => $selfId))
            : array();

        $category = $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll($conditionArray);

        return CHtml::listData($category, 'id', 'name');
    }

	public function getFormattedList($parent = null)
	{
		$children = array();
		
		if ($parent === null) {
			$children = Category::model()->roots()->findAll();
		}
		elseif(is_object($parent)) {
			$children = $parent->children()->findAll();
		}else{
			$category = Category::model()->findByPk((int)$parent);
			if($category) {
			    $children = $category->descendants()->findAll();
			}			
		}

		$list = array();

		foreach($children as $child)
		{
			$list[$child->id] = str_repeat('&emsp;', $child->level - 1) . $child->name;

			$list = CMap::mergeArray($list, $this->getFormattedList($child));
		}

		return $list;
	}

    public function getParentName()
    {
        if ($model = $this->parent()->find())
        {
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

	public function afterFind()
	{
		if ($parent = $this->parent()->find())
		{
			$this->parent_id = $parent->id;
		}

		return parent::afterFind();
	}
}
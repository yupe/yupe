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
		return array(
			array('name, description, short_description, alias', 'filter', 'filter' => 'trim'),
			array('name, alias', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
			array('name, description, alias, lang', 'required'),
			array('parent_id, status', 'numerical', 'integerOnly' => true),
			array('parent_id, status', 'length', 'max' => 11),
			array('parent_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('status', 'numerical', 'integerOnly' => true),
			array('status', 'length', 'max' => 11),
			array('name, image', 'length', 'max' => 250),
			array('alias', 'length', 'max' => 150),
			array('lang', 'length', 'max' => 2),
			array('alias', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('CategoryModule.category', 'Bad characters in {attribute} field')),
			array('alias', 'yupe\components\validators\YUniqueSlugValidator'),
			array('status', 'in', 'range' => array_keys($this->statusList)),
			array('id, parent_id, name, description, short_description, alias, status, lang', 'safe', 'on' => 'search'),
		);
	}

	public function behaviors()
	{
		$module = Yii::app()->getModule('category');

		return array(
			'imageUpload' => array(
				'class'             => 'yupe\components\behaviors\ImageUploadBehavior',
				'scenarios'         => array('insert', 'update'),
				'attributeName'     => 'image',
				'uploadPath'        => $module !== null ? $module->getUploadPath() : null,
				'imageNameCallback' => array($this, 'generateFileName'),
				'resize'            => array(
					'quality' => 70,
					'width'   => 800,
				)
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
				'condition' => $this->tableAlias . '.status = :status',
				'params'    => array(':status' => self::STATUS_PUBLISHED),
			),
			'roots'     => array(
				'condition' => $this->tableAlias . '.parent_id IS NULL',
			),
		);
	}

	public function beforeValidate()
	{
		if (!$this->alias) {
			$this->alias = yupe\helpers\YText::translit($this->name);
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
		$criteria->compare('parent_id', $this->parent_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('alias', $this->alias, true);
		$criteria->compare('lang', $this->lang);
		$criteria->compare('status', $this->status);

		return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
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

	public function getFormattedList($parent_id = null, $level = 0)
	{
		$categories = Category::model()->findAllByAttributes(array('parent_id' => $parent_id));

		$list = array();

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

	public function getImageSrc()
	{
		return Yii::app()->baseUrl . "/" .
		Yii::app()->getModule("yupe")->uploadPath . "/" .
		Yii::app()->getModule("category")->uploadPath . "/" .
		$this->image;
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
}
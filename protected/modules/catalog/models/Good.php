<?php

/**
 * Модель Catalog
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.catalog.models
 * @since 0.1
 *
 */

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
 *
 * @method Good published()
 */
class Good extends yupe\models\YModel
{
    const SPECIAL_NOT_ACTIVE = 0;
    const SPECIAL_ACTIVE = 1;

    const STATUS_ZERO = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param  string $className active record class name.
     * @return Good   the static model class
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
        return '{{catalog_good}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['category_id, name, description, alias', 'required', 'except' => 'search'],
            [
                'name, description, short_description, image, alias, price, article, data, status, is_special',
                'filter',
                'filter' => 'trim'
            ],
            [
                'name, alias, price, article, data, status, is_special',
                'filter',
                'filter' => [$obj = new CHtmlPurifier(), 'purify']
            ],
            ['status, category_id, is_special, user_id', 'numerical', 'integerOnly' => true],
            ['status, category_id, is_special, user_id', 'length', 'max' => 11],
            ['price', 'numerical'],
            ['name, image', 'length', 'max' => 250],
            ['article', 'length', 'max' => 100],
            ['alias', 'length', 'max' => 150],
            ['status', 'in', 'range' => array_keys($this->statusList)],
            ['is_special', 'in', 'range' => [0, 1]],
            [
                'alias',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('CatalogModule.catalog', 'Illegal characters in {attribute}')
            ],
            ['alias', 'unique'],
            [
                'id, category_id, name, price, article, short_description, description, alias, data, status, create_time, update_time, user_id, change_user_id, is_special',
                'safe',
                'on' => 'search'
            ],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'changeUser' => [self::BELONGS_TO, 'User', 'change_user_id'],
            'category'   => [self::BELONGS_TO, 'Category', 'category_id'],
            'user'       => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    public function scopes()
    {
        return [
            'published' => [
                'condition' => 'status = :status',
                'params'    => [':status' => self::STATUS_ACTIVE],
            ],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'                => Yii::t('CatalogModule.catalog', 'ID'),
            'category_id'       => Yii::t('CatalogModule.catalog', 'Category'),
            'name'              => Yii::t('CatalogModule.catalog', 'Name'),
            'price'             => Yii::t('CatalogModule.catalog', 'Price'),
            'article'           => Yii::t('CatalogModule.catalog', 'Article'),
            'image'             => Yii::t('CatalogModule.catalog', 'Image'),
            'short_description' => Yii::t('CatalogModule.catalog', 'Short description'),
            'description'       => Yii::t('CatalogModule.catalog', 'Description'),
            'alias'             => Yii::t('CatalogModule.catalog', 'Alias'),
            'data'              => Yii::t('CatalogModule.catalog', 'Data'),
            'status'            => Yii::t('CatalogModule.catalog', 'Status'),
            'create_time'       => Yii::t('CatalogModule.catalog', 'Added'),
            'update_time'       => Yii::t('CatalogModule.catalog', 'Updated'),
            'user_id'           => Yii::t('CatalogModule.catalog', 'User'),
            'change_user_id'    => Yii::t('CatalogModule.catalog', 'Editor'),
            'is_special'        => Yii::t('CatalogModule.catalog', 'Special'),
        ];
    }

    /**
     * @return array customized attribute descriptions (name=>description)
     */
    public function attributeDescriptions()
    {
        return [
            'id'                => Yii::t('CatalogModule.catalog', 'ID'),
            'category_id'       => Yii::t('CatalogModule.catalog', 'Category'),
            'name'              => Yii::t('CatalogModule.catalog', 'Name'),
            'price'             => Yii::t('CatalogModule.catalog', 'Price'),
            'article'           => Yii::t('CatalogModule.catalog', 'Article'),
            'image'             => Yii::t('CatalogModule.catalog', 'Image'),
            'short_description' => Yii::t('CatalogModule.catalog', 'Short description'),
            'description'       => Yii::t('CatalogModule.catalog', 'Description'),
            'alias'             => Yii::t('CatalogModule.catalog', 'Alias'),
            'data'              => Yii::t('CatalogModule.catalog', 'Data'),
            'status'            => Yii::t('CatalogModule.catalog', 'Status'),
            'create_time'       => Yii::t('CatalogModule.catalog', 'Added'),
            'update_time'       => Yii::t('CatalogModule.catalog', 'Edited'),
            'user_id'           => Yii::t('CatalogModule.catalog', 'User'),
            'change_user_id'    => Yii::t('CatalogModule.catalog', 'Editor'),
            'is_special'        => Yii::t('CatalogModule.catalog', 'Special'),
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
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('change_user_id', $this->change_user_id, true);

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('catalog');

        return [
            'CTimestampBehavior' => [
                'class'             => 'zii.behaviors.CTimestampBehavior',
                'setUpdateOnCreate' => true,
                'createAttribute'   => 'create_time',
                'updateAttribute'   => 'update_time',
            ],
            'imageUpload'        => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'image',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath,
            ],
            'seo'                => [
                'class'  => 'vendor.chemezov.yii-seo.behaviors.SeoActiveRecordBehavior',
                'route'  => '/catalog/catalog/show',
                'params' => ['name' => $this->alias],
            ],
        ];
    }

    public function beforeValidate()
    {
        $this->change_user_id = Yii::app()->user->getId();

        if ($this->isNewRecord) {
            $this->user_id = $this->change_user_id;
        }

        if (!$this->alias) {
            $this->alias = yupe\helpers\YText::translit($this->name);
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return [
            self::STATUS_ZERO       => Yii::t('CatalogModule.catalog', 'Not available'),
            self::STATUS_ACTIVE     => Yii::t('CatalogModule.catalog', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('CatalogModule.catalog', 'Not active'),
        ];
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('CatalogModule.catalog', '*unknown*');
    }

    public function getSpecialList()
    {
        return [
            self::SPECIAL_NOT_ACTIVE => Yii::t('CatalogModule.catalog', 'No'),
            self::STATUS_ACTIVE      => Yii::t('CatalogModule.catalog', 'Yes'),
        ];
    }

    public function getSpecial()
    {
        $data = $this->getSpecialList();

        return isset($data[$this->is_special]) ? $data[$this->is_special] : Yii::t(
            'CatalogModule.catalog',
            '*unknown*'
        );
    }

    /**
     * category link
     *
     * @return string html caregory link
     **/
    public function getCategoryLink()
    {
        return $this->category instanceof Category
            ? CHtml::link($this->category->name, ["/category/default/view", "id" => $this->category_id])
            : '---';
    }

    /**
     * Return url of this model
     *
     * @deprecated
     * @return string
     */
    public function getPermaLink()
    {
        return $this->getUrl();
    }
}

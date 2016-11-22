<?php

/**
 * @property integer $id
 * @property string $name_short
 * @property string $name
 * @property string $slug
 * @property integer $status
 * @property integer $sort
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $view
 *
 * @method getImageUrl
 */
class Producer extends yupe\models\YModel
{
    /**
     *
     */
    const STATUS_ZERO = 0;
    /**
     *
     */
    const STATUS_ACTIVE = 1;
    /**
     *
     */
    const STATUS_NOT_ACTIVE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{store_producer}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name_short, name, slug, status', 'required'],
            ['name_short, name, slug, short_description, description', 'filter', 'filter' => 'trim'],
            ['sort', 'numerical', 'integerOnly' => true],
            ['name_short', 'length', 'max' => 150],
            ['view', 'length', 'max' => 150],
            ['name, image, meta_title, meta_keywords, meta_description', 'length', 'max' => 250],
            ['short_description, description', 'safe'],
            ['status', 'in', 'range' => array_keys($this->getStatusList())],
            [
                'slug',
                'yupe\components\validators\YSLugValidator',
                'message' => Yii::t('StoreModule.store', 'Illegal characters in {attribute}'),
            ],
            ['slug', 'unique'],
            [
                'id, name_short, name, slug, status, sort, image, short_description, description, meta_title, meta_keywords, meta_description',
                'safe',
                'on' => 'search',
            ],
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return [
            'published' => [
                'condition' => 't.status = :status',
                'params' => [':status' => self::STATUS_ACTIVE],
                'order' => 'sort ASC',
            ],
        ];
    }

    /**
     * @return array
     */
    public function relations()
    {
        return [
            'productCount' => [self::STAT, 'Product', 'producer_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('StoreModule.store', 'ID'),
            'name_short' => Yii::t('StoreModule.store', 'Short title'),
            'name' => Yii::t('StoreModule.store', 'Title'),
            'slug' => Yii::t('StoreModule.store', 'URL'),
            'status' => Yii::t('StoreModule.store', 'Status'),
            'sort' => Yii::t('StoreModule.store', 'Order'),
            'image' => Yii::t('StoreModule.store', 'Image'),
            'short_description' => Yii::t('StoreModule.store', 'Short description'),
            'description' => Yii::t('StoreModule.store', 'Description'),
            'meta_title' => Yii::t('StoreModule.store', 'Meta title'),
            'meta_keywords' => Yii::t('StoreModule.store', 'Meta keywords'),
            'meta_description' => Yii::t('StoreModule.store', 'Meta description'),
            'view' => Yii::t('StoreModule.store', 'Template'),
        ];
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name_short', $this->name_short, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('sort', $this->sort);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 'sort'],
            ]
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     *
     * @param string $className active record class name.
     * @return Producer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
                'uploadPath' => $module !== null ? $module->uploadPath.'/producer' : null,
                'resizeOptions' => [
                    'maxWidth' => 900,
                    'maxHeight' => 900,
                ],
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
    public function getStatusList()
    {
        return [
            self::STATUS_ZERO => Yii::t('StoreModule.store', 'Not available'),
            self::STATUS_ACTIVE => Yii::t('StoreModule.store', 'Active'),
            self::STATUS_NOT_ACTIVE => Yii::t('StoreModule.store', 'Not active'),
        ];
    }

    /**
     * @return string
     */
    public function getStatusTitle()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('StoreModule.store', '*unknown*');
    }

    /**
     * @return array
     */
    public function getFormattedList()
    {
        return CHtml::listData(Producer::model()->findAll(), 'id', 'name_short');
    }
}

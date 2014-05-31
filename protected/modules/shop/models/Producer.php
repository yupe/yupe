<?php

/**
 * This is the model class for table "shop_producer".
 *
 * The followings are the available columns in table 'shop_producer':
 * @property integer $id
 * @property string $name_short
 * @property string $name
 * @property string $slug
 * @property integer $status
 * @property integer $order
 * @property string $image
 * @property string $short_description
 * @property string $description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 */
class Producer extends yupe\models\YModel
{
    const STATUS_ZERO       = 0;
    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 2;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{shop_producer}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name_short, name, slug, status', 'required'),
            array('name_short, name, slug, short_description, description', 'filter', 'filter' => 'trim'),
            array('order', 'numerical', 'integerOnly' => true),
            array('name_short', 'length', 'max' => 150),
            array('name, image, meta_title, meta_keywords, meta_description', 'length', 'max' => 250),
            array('short_description, description', 'safe'),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('slug', 'yupe\components\validators\YSLugValidator', 'message' => Yii::t('ShopModule.producer', 'Illegal characters in {attribute}')),
            array('slug', 'unique'),
            array('id, name_short, name, slug, status, order, image, short_description, description, meta_title, meta_keywords, meta_description', 'safe', 'on' => 'search'),
        );
    }


    public function scopes()
    {
        return array(
            'published' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_ACTIVE),
            ),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('ShopModule.producer', 'ID'),
            'name_short'        => Yii::t('ShopModule.producer', 'Короткое название'),
            'name'              => Yii::t('ShopModule.producer', 'Полное название'),
            'slug'              => Yii::t('ShopModule.producer', 'URL'),
            'status'            => Yii::t('ShopModule.producer', 'Статус'),
            'order'             => Yii::t('ShopModule.producer', 'Порядок в меню'),
            'image'             => Yii::t('ShopModule.producer', 'Изображение'),
            'short_description' => Yii::t('ShopModule.producer', 'Короткое описание'),
            'description'       => Yii::t('ShopModule.producer', 'Описание'),
            'meta_title'        => Yii::t('ShopModule.producer', 'Meta title'),
            'meta_keywords'     => Yii::t('ShopModule.producer', 'Meta keywords'),
            'meta_description'  => Yii::t('ShopModule.producer', 'Meta description'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('name_short', $this->name_short, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('order', $this->order);
        $criteria->compare('image', $this->image, true);
        $criteria->compare('short_description', $this->short_description, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Producer the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
                'uploadPath'    => $module !== null ? $module->uploadPath . '/producer' : null,
            ),
            'imageThumb'  => array(
                'class'         => 'yupe\components\behaviors\ImageThumbBehavior',
                'uploadPath'    =>  $module->uploadPath . '/producer',
                'attributeName' => 'image',
            ),
        );
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ZERO       => 'Недоступен',
            self::STATUS_ACTIVE     => 'Активен',
            self::STATUS_NOT_ACTIVE => 'Неактивен',
        );
    }

    public function getStatusTitle()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : '*неизвестен*';
    }

    public function getFormattedList()
    {
        $producers = Producer::model()->findAll();
        $list      = array();
        foreach ($producers as $key => $producer)
        {
            $list[$producer->id] = $producer->name_short;
        }
        return $list;
    }
}

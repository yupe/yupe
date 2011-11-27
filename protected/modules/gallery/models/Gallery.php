<?php

/**
 * This is the model class for table "Gallery".
 *
 * The followings are the available columns in table 'Gallery':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property integer $status
 */
class Gallery extends CActiveRecord
{
    const STATUS_PUBLIC = 1;

    const STATUS_DRAFT  = 0;

    /**
     * Returns the static model of the specified AR class.
     * @return Gallery the static model class
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
        return '{{gallery}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 300),
            array('description', 'length', 'max' => 500),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, description, status', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'imagesRell' => array(self::HAS_MANY, 'ImageToGallery', 'galleryId'),
            'images' => array(self::HAS_MANY, 'Images', 'image_id', 'through' => 'imagesRell'),
            'imagesCount' => array(self::STAT, 'ImageToGallery', 'galleryId')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('gallery', 'Id'),
            'name' => Yii::t('gallery', 'Название'),
            'description' => Yii::t('gallery', 'Описание'),
            'status' => Yii::t('gallery', 'Статус'),
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
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
                                                   'criteria' => $criteria,
                                              ));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLIC => Yii::t('gallery', 'опубликовано'),
            self::STATUS_DRAFT => Yii::t('gallery', 'скрыто'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status]
            : Yii::t('gallery', '*неизвестно*');
    }

    public function defaultScope()
    {
        return array(
            'condition' => 'status = :status',
            'params' => array(':status' => self::STATUS_PUBLIC)
        );
    }

    public function addImage(Image $image)
    {
        $im2g = new ImageToGallery;

        $im2g->setAttributes(array(
                                  'image_id' => $image->id,
                                  'galleryId' => $this->id
                             ));

        return $im2g->save() ? true : false;
    }
}
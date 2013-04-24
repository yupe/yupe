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
class Gallery extends YModel
{
    const STATUS_PUBLIC = 1;
    const STATUS_DRAFT  = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
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
        return '{{gallery_gallery}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, description', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 250),            
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
            'imagesRell'  => array(self::HAS_MANY, 'ImageToGallery', array('gallery_id' => 'id')),
            'images'      => array(self::HAS_MANY, 'Image', 'image_id', 'through' => 'imagesRell'),
            'imagesCount' => array(self::STAT, 'ImageToGallery', 'gallery_id'),
        );
    }

    public function defaultScope()
    {
        return array(
            'condition' => 'status = :status',
            'params'    => array(':status' => self::STATUS_PUBLIC),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('GalleryModule.gallery', 'Id'),
            'name'        => Yii::t('GalleryModule.gallery', 'Название'),
            'description' => Yii::t('GalleryModule.gallery', 'Описание'),
            'status'      => Yii::t('GalleryModule.gallery', 'Статус'),
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

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_PUBLIC => Yii::t('GalleryModule.gallery', 'опубликовано'),
            self::STATUS_DRAFT  => Yii::t('GalleryModule.gallery', 'скрыто'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('GalleryModule.gallery', '*неизвестно*');
    }

    public function addImage(Image $image)
    {
        $im2g = new ImageToGallery;

        $im2g->setAttributes(array(
            'image_id'  => $image->id,
            'gallery_id' => $this->id,
        ));

        return $im2g->save() ? true : false;
    }

    /**
     * Получаем картинку для галереи:
     * 
     * @return string image Url
     **/
    public function previewImage()
    {
        return $this->imagesCount > 0
            ? $this->images[0]->getUrl(190, 190)
            : Yii::app()->theme->baseUrl . '/web/images/thumbnail.png';
    }
}
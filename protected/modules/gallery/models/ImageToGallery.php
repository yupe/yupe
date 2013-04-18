<?php

/**
 * This is the model class for table "ImageToGallery".
 *
 * The followings are the available columns in table 'ImageToGallery':
 * @property string $id
 * @property string $image_id
 * @property string $gallery_id
 * @property string $creation_date
 *
 * The followings are the available model relations:
 * @property Gallery $gallery
 * @property Image $image
 */
class ImageToGallery extends YModel
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return ImageToGallery the static model class
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
        return '{{gallery_image_to_gallery}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('image_id, gallery_id', 'required'),
            array('image_id, gallery_id', 'numerical', 'integerOnly' => true),
            array('id, image_id, gallery_id, creation_date', 'safe', 'on' => 'search'),
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
            'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
            'image'   => array(self::BELONGS_TO, 'Image', 'image_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('GalleryModule.gallery', 'id'),
            'image_id'      => Yii::t('GalleryModule.gallery', 'Изображение'),
            'gallery_id'    => Yii::t('GalleryModule.gallery', 'Галерея'),
            'creation_date' => Yii::t('GalleryModule.gallery', 'Дата добавления'),
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
        $criteria->compare('image_id', $this->image_id, true);
        $criteria->compare('gallery_id', $this->gallery_id, true);
        $criteria->compare('creation_date', $this->creation_date, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)
            $this->creation_date = YDbMigration::expression('NOW()');
        return parent::beforeSave();
    }
}
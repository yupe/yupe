<?php

/**
 * This is the model class for table "ImageToGallery".
 *
 * The followings are the available columns in table 'ImageToGallery':
 * @property string $id
 * @property string $imageId
 * @property string $galleryId
 * @property string $creationDate
 *
 * The followings are the available model relations:
 * @property Gallery $gallery
 * @property Image $image
 */
class ImageToGallery extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
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
        return '{{image_to_gallery}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('imageId, galleryId', 'required'),
            array('imageId, galleryId', 'numerical', 'integerOnly' => true),
            array('id, imageId, galleryId, creationDate', 'safe', 'on' => 'search'),
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
            'gallery' => array(self::BELONGS_TO, 'Gallery', 'galleryId'),
            'image' => array(self::BELONGS_TO, 'Image', 'imageId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('gallery', 'id'),
            'imageId' => Yii::t('gallery', 'Изображение'),
            'galleryId' => Yii::t('gallery', 'Галерея'),
            'creationDate' => Yii::t('gallery', 'Дата добавления'),
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
        $criteria->compare('imageId', $this->imageId, true);
        $criteria->compare('galleryId', $this->galleryId, true);
        $criteria->compare('creationDate', $this->creationDate, true);

        return new CActiveDataProvider($this, array(
                                                   'criteria' => $criteria,
                                              ));
    }

    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $this->creationDate = new CDbExpression('NOW()');
            }

            return true;
        }

        return false;
    }
}
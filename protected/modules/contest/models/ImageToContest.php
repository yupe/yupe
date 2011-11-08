<?php

/**
 * This is the model class for table "ImageToContest".
 *
 * The followings are the available columns in table 'ImageToContest':
 * @property string $id
 * @property string $image_id
 * @property string $contest_id
 * @property string $creation_date
 */
class ImageToContest extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return ImageToContest the static model class
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
        return '{{image_to_contest}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('image_id, contest_id', 'required'),
            array('image_id, contest_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, image_id, contest_id, creation_date', 'safe', 'on' => 'search'),
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
            'image' => array(self::BELONGS_TO, 'Image', 'image_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'image_id' => 'Image',
            'contest_id' => 'Contest',
            'creation_date' => 'Creation Date',
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
        $criteria->compare('contest_id', $this->contest_id, true);
        $criteria->compare('creation_date', $this->creation_date, true);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }

    public function beforeSave()
    {
        if ($this->isNewRecord)        
            $this->creation_date = new CDbExpression('NOW()');        

        return parent::beforeSave();
    }
}
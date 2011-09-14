<?php

/**
 * This is the model class for table "ImageToContest".
 *
 * The followings are the available columns in table 'ImageToContest':
 * @property string $id
 * @property string $imageId
 * @property string $contestId
 * @property string $creationDate
 */
class ImageToContest extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return ImageToContest the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ImageToContest';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('imageId, contestId', 'required'),
			array('imageId, contestId', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, imageId, contestId, creationDate', 'safe', 'on'=>'search'),
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
			'image'   => array(self::BELONGS_TO, 'Image', 'imageId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'imageId' => 'Image',
			'contestId' => 'Contest',
			'creationDate' => 'Creation Date',
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

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('imageId',$this->imageId,true);
		$criteria->compare('contestId',$this->contestId,true);
		$criteria->compare('creationDate',$this->creationDate,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->creationDate = new CDbExpression('NOW()');
			}

			return true;
		}

		return false;
	}
}
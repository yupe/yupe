<?php

/**
 * This is the model class for table "dictionary_group".
 *
 * The followings are the available columns in table 'dictionary_group':
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property string $creation_date
 * @property string $update_date
 * @property string $create_user_id
 * @property string $update_user_id
 *
 * The followings are the available model relations:
 * @property DictionaryData[] $dictionaryDatas
 * @property User $updateUser
 * @property User $createUser
 */
class DictionaryGroup extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return DictionaryGroup the static model class
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
		return 'dictionary_group';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'required'),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>150),
			array('description', 'length', 'max'=>300),
			array('create_user_id, update_user_id', 'length', 'max'=>10),
			array('code','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, name, description, creation_date, update_date, create_user_id, update_user_id', 'safe', 'on'=>'search'),
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
			'dictionaryData' => array(self::HAS_MANY, 'DictionaryData', 'group_id'),
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
			'dataCount' => array(self::STAT, 'DictionaryData', 'group_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('dictionary','id'),
			'code' => Yii::t('dictionary','Код'),
			'name' => Yii::t('dictionary','Название'),
			'description' => Yii::t('dictionary','Описание'),
			'creation_date' => Yii::t('dictionary','Дата создания'),
			'update_date' => Yii::t('dictionary','Дата изменения'),
			'create_user_id' => Yii::t('dictionary','Создал'),
			'update_user_id' => Yii::t('dictionary','Изменил'),
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('create_user_id',$this->create_user_id,true);
		$criteria->compare('update_user_id',$this->update_user_id,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}

	public function beforeSave()
	{
		if($this->isNewRecord)
		{
			$this->update_user_id = $this->create_user_id = Yii::app()->user->getId();
			
			$this->creation_date = $this->update_date = new CDbExpression('NOW()');			
		}
		else
		{
			$this->update_user_id = Yii::app()->user->getId();
			
			$this->update_date = new CDbExpression('NOW()');			
		}

		return parent::beforeSave();
	}

	public function getData()
	{
		return DictionaryData::model()->cache(Yii::app()->getModule('yupe')->coreCacheTime)->findAll('group_id = :group_id',array(
			':group_id' => $this->id
		));
	}
}
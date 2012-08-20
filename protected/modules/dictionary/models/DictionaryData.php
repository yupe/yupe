<?php

/**
 * This is the model class for table "dictionary_data".
 *
 * The followings are the available columns in table 'dictionary_data':
 * @property string $id
 * @property string $group_id
 * @property string $code
 * @property string $name
 * @property string $value
 * @property string $description
 * @property string $creation_date
 * @property string $update_date
 * @property string $create_user_id
 * @property string $update_user_id
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property User $updateUser
 * @property DictionaryGroup $group
 * @property User $createUser
 */
class DictionaryData extends CActiveRecord
{
	const STATUS_ACTIVE = 1;

	const STATUS_DELETED = 0;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className
     * @return DictionaryData the static model class
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
		return 'dictionary_data';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('group_id, code, name, value', 'required'),
			array('status', 'numerical', 'integerOnly'=>TRUE),
			array('group_id, create_user_id, update_user_id', 'length', 'max'=>10),
			array('code', 'length', 'max'=>50),
			array('name', 'length', 'max'=>150),
			array('description', 'length', 'max'=>300),
			array('code','unique'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, group_id, code, name, description, creation_date, update_date, create_user_id, update_user_id, status', 'safe', 'on'=>'search'),
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
			'updateUser' => array(self::BELONGS_TO, 'User', 'update_user_id'),
			'group' => array(self::BELONGS_TO, 'DictionaryGroup', 'group_id'),
			'createUser' => array(self::BELONGS_TO, 'User', 'create_user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('dictionary','id'),
			'group_id' => Yii::t('dictionary','Группа'),
			'code' => Yii::t('dictionary','Код'),
			'name' => Yii::t('dictionary','Название'),
			'value' => Yii::t('dictionary','Значение'),
			'description' => Yii::t('dictionary','Описание'),
			'creation_date' => Yii::t('dictionary','Дата создания'),
			'update_date' => Yii::t('dictionary','Дата обновления'),
			'create_user_id' => Yii::t('dictionary','Создал'),
			'update_user_id' => Yii::t('dictionary','Обновил'),
			'status' => Yii::t('dictionary','Активно'),
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

		$criteria->compare('id',$this->id,TRUE);
		$criteria->compare('group_id',$this->group_id,TRUE);
		$criteria->compare('code',$this->code,TRUE);
		$criteria->compare('name',$this->name,TRUE);
		$criteria->compare('description',$this->description,TRUE);
		$criteria->compare('creation_date',$this->creation_date,TRUE);
		$criteria->compare('update_date',$this->update_date,TRUE);
		$criteria->compare('create_user_id',$this->create_user_id,TRUE);
		$criteria->compare('update_user_id',$this->update_user_id,TRUE);
		$criteria->compare('status',$this->status);

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


	public function getStatusList()
	{
		return array(
			self::STATUS_ACTIVE  => Yii::t('dictionary','Да'),
			self::STATUS_DELETED => Yii::t('dictionary','Нет'),
		);
	}

	public function getStatus()
	{
		$data = $this->getStatusList();

		return isset($data[$this->status]) ? $data[$this->status] : Yii::t('dictionary','*неизвестно*');
	}

	public function getByCode($code)
	{
		return $this->cache(Yii::app()->getModule('yupe')->coreCacheTime)->find('code = :code',array('code' => $code));
	}
}
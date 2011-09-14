<?php
/**
 * This is the model class for table "Login".
 *
 * The followings are the available columns in table 'Login':
 * @property string $id
 * @property string $userId
 * @property string $identityId
 * @property string $type
 * @property string $creationDate
 *
 * The followings are the available model relations:
 * @property User $user
 */
class Login extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Login the static model class
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
		return '{{Login}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('userId, identityId, type', 'required'),
			array('userId, identityId', 'length', 'max'=>10),
			array('type', 'length', 'max'=>50),
			array('id, userId, identityId, type, creationDate', 'safe', 'on'=>'search'),
		);
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

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('user','id'),
			'userId' => Yii::t('user','Пользователь'),
			'identityId' => Yii::t('user','Идентификатор'),
			'type' => Yii::t('user','Тип'),
			'creationDate' => Yii::t('user','Дата создания'),
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
		$criteria->compare('userId',$this->userId,true);
		$criteria->compare('identityId',$this->identityId,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('creationDate',$this->creationDate,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}
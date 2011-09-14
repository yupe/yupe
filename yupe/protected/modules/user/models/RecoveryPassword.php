<?php

/**
 * This is the model class for table "{{RecoveryPassword}}".
 *
 * The followings are the available columns in table '{{RecoveryPassword}}':
 * @property integer $id
 * @property integer $userId
 * @property string $creationDate
 * @property string $code
 */
class RecoveryPassword extends CActiveRecord
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public function tableName()
	{
		return '{{RecoveryPassword}}';
	}

	public function rules()
	{		
		return array(
			array('userId, code','required'),
			array('userId', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>32, 'min'=>32),			
			array('id, userId, creationDate, code', 'safe', 'on'=>'search'),
		);
	}

	
	public function relations()
	{		
		return array(
			'user' => array(self::BELONGS_TO, 'User', 'userId'),
		);
	}

	
	public function attributeLabels()
	{
		return array(
			'id'     => Yii::t('user','Id'),
			'userId' => Yii::t('user','Пользователь'),
			'creationDate' => Yii::t('user','Дата создания'),
			'code' => Yii::t('user','Код'),
		);
	}

	
	public function search()
	{		
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('userId',$this->userId);

		$criteria->compare('creationDate',$this->creationDate,true);

		$criteria->compare('code',$this->code,true);

		return new CActiveDataProvider('RecoveryPassword', array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function generateRecoveryCode($userId)
	{
		return md5(time().$userId.uniqid());
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
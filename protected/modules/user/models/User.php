<?php

/**
 * This is the model class for table "{{User}}".
 *
 * The followings are the available columns in table '{{User}}':
 * @property integer $id
 * @property string $creationDate
 * @property string $changeDate
 * @property string $firstName
 * @property string $lastName
 * @property string $nickName
 * @property string $email
 * @property integer $gender
 * @property string $avatar
 * @property string $password
 * @property string $salt
 * @property integer $status
 * @property integer $accessLevel
 * @property string $lastVisit
 * @property string $registrationDate
 * @property string $registrationIp
 * @property string $activationIp
 */
class User extends CActiveRecord
{	
	const GENDER_MALE   = 1;
	const GENDER_FEMALE = 2;
	const GENDER_THING  = 0;
	
	const STATUS_ACTIVE = 1;
	const STATUS_BLOCK  = 0;	
	
	const ACCESS_LEVEL_USER   = 0;
	const ACCESS_LEVEL_ADMIN  = 1;
	
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{User}}';
	}
	
	public function validatePassword($password)
	{		
		if($this->password === Registration::model()->hashPassword($password,$this->salt))
		{
			return true;
		}		
		return false;
	}
	
	public function getAccessLevel()
	{
		$data = $this->getAccessLevelsList();
		return array_key_exists($this->accessLevel,$data) ? $data[$this->accessLevel] : Yii::t('user','ммм...такого доступа нет');
	}
	
	public function getAccessLevelsList()
	{
		return array(
			self::ACCESS_LEVEL_ADMIN => Yii::t('user','Администратор'),
			self::ACCESS_LEVEL_USER  => Yii::t('user','Пользователь')
		);
	}	
	
	
	
	public function getStatusList()
	{
         return array(
			self::STATUS_ACTIVE => Yii::t('user','Активен'),
			self::STATUS_BLOCK  => Yii::t('user','Заблокирован'),			
		 );
	}
	
	public function getStatus()
	{
		$data = $this->getStatusList();
		return array_key_exists($this->status,$data) ? $data[$this->status] : Yii::t('user','ммм...статуса такого нет');
	}
	
	
	
	public function getGendersList()
	{
		return array(
			self::GENDER_FEMALE => Yii::t('user','женский'),
			self::GENDER_MALE   => Yii::t('user','мужской'),
			self::GENDER_THING  => Yii::t('user','неизвестно')
		);
	}
	
	public function getGender()
	{
		$data = $this->getGendersList();
		return array_key_exists($this->gender,$data) ? $data[$this->gender] : Yii::t('user','ммм...пола такого нет');
	}
	
	/**
	 * Returns the static model of the specified AR class.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nickName, email, password', 'required'),
			array('gender, status, accessLevel, useGravatar', 'numerical', 'integerOnly'=>true),
			array('firstName, lastName, nickName, email', 'length', 'max'=>150),
			array('password, salt', 'length', 'max'=>32),
			array('registrationIp, activationIp, registrationDate', 'length', 'max'=>20),
			array('email','email'),
			array('email','unique','message' => Yii::t('user','Данный email уже используется другим пользователем')),
			array('nickName','unique','message' => Yii::t('user','Данный ник уже используется другим пользователем')),
			array('avatar', 'file', 'types'=>implode(',',Yii::app()->getModule('user')->avatarExtensions), 'maxSize' => Yii::app()->getModule('user')->avatarMaxSize,'allowEmpty' => true),
			array('useGravatar','in','range' => array(0,1)),			
			array('id, creationDate, changeDate, firstName, lastName, nickName, email, gender, avatar, password, salt, status, accessLevel, lastVisit, registrationDate, registrationIp, activationIp', 'safe', 'on'=>'search'),
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
			'profile' => array(self::HAS_ONE,'Profile','userId')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('user','Id'),
			'creationDate' => Yii::t('user','Дата активации'),
			'changeDate'   => Yii::t('user','Дата изменения'),
			'firstName'    => Yii::t('user','Имя'),
			'lastName'     => Yii::t('user','Фамилия'),
			'nickName'     => Yii::t('user','Ник'),
			'email'        => Yii::t('user','Email'),
			'gender'       => Yii::t('user','Пол'),			
			'password'     => Yii::t('user','Пароль'),
			'salt'         => Yii::t('user','Соль'),
			'status'       => Yii::t('user','Статус'),
			'accessLevel'  => Yii::t('user','Уровень доступа'),
			'lastVisit'    => Yii::t('user','Последний визит'),
			'registrationDate' => Yii::t('user','Дата регистрации'),
			'registrationIp'   => Yii::t('user','Ip регистрации'),
			'activationIp'     => Yii::t('user','Ip активации'),
			'avatar'           => Yii::t('user','Аватар'),
			'useGravatar'      => Yii::t('user','Граватара'),
		);
	}

	
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);

		$criteria->compare('creationDate',$this->creationDate,true);

		$criteria->compare('changeDate',$this->changeDate,true);

		$criteria->compare('firstName',$this->firstName,true);

		$criteria->compare('lastName',$this->lastName,true);

		$criteria->compare('nickName',$this->nickName,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('gender',$this->gender);	

		$criteria->compare('password',$this->password,true);

		$criteria->compare('salt',$this->salt,true);

		$criteria->compare('status',$this->status);

		$criteria->compare('accessLevel',$this->accessLevel);

		$criteria->compare('lastVisit',$this->lastVisit,true);

		$criteria->compare('registrationDate',$this->registrationDate,true);

		$criteria->compare('registrationIp',$this->registrationIp,true);

		$criteria->compare('activationIp',$this->activationIp,true);

		return new CActiveDataProvider('User', array(
			'criteria'=>$criteria,
		));
	}
	
	
	public function beforeSave()
	{
		if(parent::beforeSave())
		{
			if($this->isNewRecord)
			{
				$this->lastVisit = $this->creationDate = $this->changeDate = new CDbExpression('NOW()');				
				$this->activationIp = Yii::app()->request->userHostAddress;
			}
			
			return true;
		}
		
		return false;		
	}
	
	
	public function scopes()
	{
		return array(
			'active'  => array('condition' => 'status='.self::STATUS_ACTIVE),
			'blocked' => array('condition' => 'status='.self::STATUS_BLOCK),
			'admin'   => array('condition' => 'accessLevel='.self::ACCESS_LEVEL_ADMIN),
			'user'    => array('condition' => 'accessLevel='.self::ACCESS_LEVEL_USER),			
		);
	}
	
	// проверить уникальность логина по двум таблицам
	public function checkNickNameUnique($nickName)
	{
		$nickName = trim(strtolower($nickName));
		
		// проверим по таблице Registration
		$registration = Registration::model()->find('nickName = :nickName',array(':nickName' => $nickName));
		
		if(!is_null($registration))
		{
			return false;
		}
		
		// проверим по табличке User		
		$user = User::model()->find('nickName = :nickName',array(':nickName' => $nickName));
				
		return is_null($user) ? true : false;
	}
	
	// проверить уникальность логина по двум таблицам
	public function checkEmailUnique($email)
	{
		$email = trim(strtolower($email));
		
		// проверим по таблице Registration
		$registration = Registration::model()->find('email = :email',array(':email' => $email));
		
		if(!is_null($registration))
		{
			return false;
		}
		
		// проверим по табличке User		
		$user = User::model()->find('email = :email',array(':email' => $email));
		
		return is_null($user) ? true : false;
	}	
	
	public function getAvatar($htmlOptions = null)
	{
		if($this->useGravatar && $this->email)
		{
			return CHtml::image('http://gravatar.com/avatar/'.md5($this->email),$this->nickName,$htmlOptions);
		}
		elseif($this->avatar)
		{			
		    return CHtml::image($this->avatar,$this->nickName,$htmlOptions);     	
		}
		
		return '';
	}
	
	public function getFullName($separator=' ')
	{
		return $this->firstName || $this->lastName ? $this->lastName.$separator.$this->firstName : $this->nickName;
	}
	
	public function createAccount($nickName,$email,$params=null,$password=null,$salt=null)
	{
		$user = new User();
			
		$salt = is_null($salt) ? Registration::model()->generateSalt() : $salt;
		
		$password = is_null($password) ? Registration::model()->generateRandomPassword() : $password;
		
		$user->setAttributes(array(
			'nickName' => $nickName,
			'email'    => $email,
			'salt'     => $salt,
			'password' => Registration::model()->hashPassword($password,$salt),
			'registrationDate' => new CDbExpression('NOW()'),
            'registrationIp'   => Yii::app()->request->userHostAddress
		));
		
		if(is_array($params) && count($params))
		{			
			foreach($params as $key => $value)
			{
				$user->$key = $value;				
			}
		}
		
		$transaction = Yii::app()->db->beginTransaction();	
		
		try
		{
			if($user->save())
			{
				$profile = new Profile();
				
				$profile->userId = $user->id;
				
				if(!$profile->save())
				{			
					throw new CDbException($profile->getErrors());
				}
				
				$transaction->commit();
				
				return $user;
			}
			
			$transaction->rollback();
			
			return $user;		
		}
		catch(CDbException $e)
		{
			Yii::log($e->getMessage(),CLogger::LEVEL_ERROR);
			
			$transaction->rollback();			
		}
		
		return false;
	}
	
	
	public function createSocialAccount($nickName,$email,$firstName,$secondName,$sid,$sType,$params=null)
	{
		$salt = Registration::model()->generateSalt();
		
		$password = Registration::model()->hashPassword(Registration::model()->generateRandomPassword(),$salt);		
	
		$user = $this->createAccount($nickName,$email,$params,$password,$salt,$params);		
			
		if(is_object($user) && !$user->hasErrors())
		{
			$login = new Login();
			
			$login->setAttributes(array(
				'userId'     => $user->id,
				'identityId' => $sid,
				'type'       => $sType
			));		
			
			if(!$login->save())
			{
				Yii::log(print_r($login->getErrors(),true),CLogger::LEVEL_ERROR);
				
				$user->delete();
				
				return false;
			}
			
			return $login;			
		}
		
		Yii::log(print_r($user->getErrors(),true),CLogger::LEVEL_ERROR);
		
		return false;
	}	
}
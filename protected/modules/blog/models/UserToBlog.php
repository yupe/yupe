<?php

/**
 * This is the model class for table "user_to_blog".
 *
 * The followings are the available columns in table 'user_to_blog':
 * @property string $id
 * @property string $user_id
 * @property string $blog_id
 * @property string $create_date
 * @property string $update_date
 * @property integer $role
 * @property integer $status
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Blog $blog
 * @property User $user
 */
class UserToBlog extends CActiveRecord
{
	const ROLE_USER = 1;

	const ROLE_MODERATOR = 2;

	const ROLE_ADMIN = 3;

	const STATUS_ACTIVE = 1;

	const STATUS_BLOCK = 2;

	public function getRoleList()
	{
        return array(
        	self::ROLE_USER      => Yii::t('blog','Пользователь'),
        	self::ROLE_MODERATOR => Yii::t('blog','Модератор'),
        	self::ROLE_ADMIN     => Yii::t('blog','Администратор'),        	
        );        
	}

	public function getRole()
	{
		$data = $this->getRoleList();

		return isset($data[$this->role]) ? $data[$this->role] : Yii::t('blog','*неизвестно*');
	}

	public function getStatusList()
	{
		return array(
			self::STATUS_ACTIVE => Yii::t('blog','Активен'),
			self::STATUS_BLOCK  => Yii::t('blog','Заблокирован'),			
		);
	}

	public function getStatus()
	{
		$data = $this->getStatusList();

		return isset($data[$this->status]) ? $data[$this->status] : Yii::t('blog','*неизвестно*');
	}

	public function behaviors()
	{
		return array(
			'CTimestampBehavior' => array(
				'class' => 'zii.behaviors.CTimestampBehavior',
				'createAttribute' => 'create_date',
				'updateAttribute' => 'update_date',
			)
		);
    }

	/**
	 * Returns the static model of the specified AR class.
	 * @return UserToBlog the static model class
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
		return '{{user_to_blog}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, blog_id', 'required'),
			array('role, status, user_id, blog_id', 'numerical', 'integerOnly'=>true),
			array('user_id, blog_id, create_date, update_date', 'length', 'max'=>10),
			array('note', 'length', 'max'=>300),
			array('role','in','range'  => array_keys($this->getRoleList())),		
			array('status','in','range'=> array_keys($this->getStatusList())),
			array('note','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),
			array('id, user_id, blog_id, create_date, update_date, role, status, note', 'safe', 'on'=>'search'),
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
			'blog' => array(self::BELONGS_TO, 'Blog', 'blog_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('blog','id'),
			'user_id' => Yii::t('blog','Пользователь'),
			'blog_id' => Yii::t('blog','Блог'),
			'create_date' => Yii::t('blog','Дата создания'),
			'update_date' => Yii::t('blog','Дата обновления'),
			'role' => Yii::t('blog','Роль'),
			'status' => Yii::t('blog','Статус'),
			'note' => Yii::t('blog','Примечание'),
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('blog_id',$this->blog_id,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('role',$this->role);
		$criteria->compare('status',$this->status);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
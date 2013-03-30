<?php

/**
 * This is the model class for table "{{user_user_auth_assignment}}".
 *
 * The followings are the available columns in table '{{user_user_auth_assignment}}':
 * @property string $itemname
 * @property integer $userid
 * @property string $bizrule
 * @property string $data
 */
class UserAuthAssignment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserAuthAssignment the static model class
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
		return '{{user_user_auth_assignment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('itemname, userid, bizrule, data', 'required'),
			array('userid', 'numerical', 'integerOnly'=>true),
			array('itemname', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('itemname, userid, bizrule, data', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'itemname' => Yii::t('UserModule.rbac','Объект доступа'),
			'userid'   => Yii::t('UserModule.rbac','Пользователь'),
			'bizrule'  => Yii::t('UserModule.rbac','Правило назначения'),
			'data'     => Yii::t('UserModule.rbac','Данные'),
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

		$criteria->compare('itemname',$this->itemname,true);
		$criteria->compare('userid',$this->userid);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
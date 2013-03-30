<?php

/**
 * This is the model class for table "{{user_auth_item}}".
 *
 * The followings are the available columns in table '{{user_auth_item}}':
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $bizrule
 * @property string $data
 * @property string $detailed_description
 */
class UserAuthItem extends CActiveRecord
{
    const USER_RBAC_OPERATION              = 0;
    const USER_RBAC_TASK                   = 1;
    const USER_RBAC_ROLE                   = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserAuthItem the static model class
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
		return '{{user_auth_item}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, type, description, bizrule, data, detailed_description', 'required'),
			array('type', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('name, type, description, bizrule, data, detailed_description', 'safe', 'on'=>'search'),
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

    public function scopes()
    {
        return array(
            'group'       => array(
                'condition' => 'type = :type',
                'params'    => array(':type' => self::USER_RBAC_ROLE),
            ),
            'task'      => array(
                'condition' => 'type = :type',
                'params'    => array(':status' => self::USER_RBAC_TASK),
            ),
            'operation' => array(
                'condition' => 'type = :status',
                'params'    => array(':status' => self::USER_RBAC_OPERATION),
            ),
        );
    }


    /**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'name' => Yii::t('UserModule.rbac', 'Ключевое слово'),
			'type' => Yii::t('UserModule.rbac', 'Тип'),
			'description' => Yii::t('UserModule.rbac', 'Название'),
			'bizrule' => Yii::t('UserModule.rbac', 'Правило назначения'),
			'data' => Yii::t('UserModule.rbac', 'Данные'),
			'detailed_description' => Yii::t('UserModule.rbac', 'Описание'),
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

		$criteria->compare('name',$this->name,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('bizrule',$this->bizrule,true);
		$criteria->compare('data',$this->data,true);
		$criteria->compare('detailed_description',$this->detailed_description,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
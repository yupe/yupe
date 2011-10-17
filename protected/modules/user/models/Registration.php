<?php

/**
 * This is the model class for table "{{Registration}}".
 *
 * The followings are the available columns in table '{{Registration}}':
 * @property integer $id
 * @property string $creation_date
 * @property string $nick_name
 * @property string $email
 * @property string $salt
 * @property string $password
 * @property string $code
 */
class Registration extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @return Registration the static model class
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
        return '{{registration}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(            
            array('nick_name, email','filter','filter' => 'trim'),
            array('nick_name, email','filter','filter' => array($obj = new CHtmlPurifier(),'purify')),
            array('nick_name, email, password', 'required'),
            array('email', 'email'),
            array('nick_name, email', 'length', 'max' => 150),                        
            array('salt, password, code', 'length', 'max' => 32),
            array('code', 'unique', 'message' => Yii::t('user', 'Ошибка! Код активации не уникален!')),
            array('email', 'unique', 'message' => Yii::t('user', 'Данный email уже используется другим пользователем')),
            array('nick_name', 'unique', 'message' => Yii::t('user', 'Данный ник уже используется другим пользователем')),
            array('id, creation_date, nick_name, email, salt, password, code', 'safe', 'on' => 'search'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('user', 'Id'),
            'creation_date' => Yii::t('user', 'Дата создания'),
            'nick_name' => Yii::t('user', 'Ник'),
            'email' => Yii::t('user', 'Email'),
            'salt' => Yii::t('user', 'Соль'),
            'password' => Yii::t('user', 'Пароль'),
            'code' => Yii::t('user', 'Код активации'),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);

        $criteria->compare('creation_date', $this->creation_date, true);

        $criteria->compare('nick_name', $this->nick_name, true);

        $criteria->compare('email', $this->email, true);

        $criteria->compare('salt', $this->salt, true);

        $criteria->compare('password', $this->password, true);

        $criteria->compare('code', $this->code, true);

        return new CActiveDataProvider('Registration', array(
                                                            'criteria' => $criteria,
                                                       ));
    }


    public function beforeSave()
    {        
        if ($this->isNewRecord)
        {
            $this->creation_date = new CDbExpression('NOW()');
            $this->salt = $this->generateSalt();
            $this->password = $this->hashPassword($this->password, $this->salt);
            $this->code = $this->generateActivationCode();
            $this->ip = Yii::app()->request->userHostAddress;
        }

        return parent::beforeSave();
    }


    public function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }


    public function generateSalt()
    {
        return uniqid('', true);
    }


    public function generateRandomPassword($length = null)
    {
        if (!$length)        
            $length = Yii::app()->getModule('user')->minPasswordLength;
        
        return substr(md5(uniqid(mt_rand(), true) . time()), 0, $length);
    }


    public function generateActivationCode()
    {
        return md5(time() . $this->email . uniqid());
    }
}
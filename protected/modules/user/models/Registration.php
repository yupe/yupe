<?php

/**
 * This is the model class for table "{{Registration}}".
 *
 * The followings are the available columns in table '{{Registration}}':
 * @property integer $id
 * @property string $creationDate
 * @property string $nickName
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
        return '{{Registration}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('nickName, email, password', 'required'),
            array('nickName', 'length', 'max' => 100),
            array('email', 'length', 'min' => 5, 'max' => 150),
            array('salt, password, code', 'length', 'max' => 32),
            array('email', 'unique', 'message' => Yii::t('user', 'Данный email уже используется другим пользователем')),
            array('nickName', 'unique', 'message' => Yii::t('user', 'Данный ник уже используется другим пользователем')),
            array('id, creationDate, nickName, email, salt, password, code', 'safe', 'on' => 'search'),
        );
    }


    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('user', 'Id'),
            'creationDate' => Yii::t('user', 'Дата создания'),
            'nickName' => Yii::t('user', 'Ник'),
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

        $criteria->compare('creationDate', $this->creationDate, true);

        $criteria->compare('nickName', $this->nickName, true);

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
        if (parent::beforeSave()) {
            if ($this->isNewRecord) {
                $this->creationDate = new CDbExpression('NOW()');
                $this->salt = $this->generateSalt();
                $this->password = $this->hashPassword($this->password, $this->salt);
                $this->code = $this->generateActivationCode();
                $this->ip = Yii::app()->request->userHostAddress;
            }

            return true;
        }
        else
        {
            return false;
        }
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
        if (!$length) {
            $length = Yii::app()->getModule('user')->minPasswordLength;
        }
        return substr(md5(uniqid(mt_rand(), true) . time()), 0, $length);
    }


    public function generateActivationCode()
    {
        return md5(time() . $this->email . uniqid());
    }
}
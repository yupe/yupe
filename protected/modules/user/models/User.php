<?php

/**
 * This is the model class for table "{{User}}".
 *
 * The followings are the available columns in table '{{User}}':
 * @property integer $id
 * @property string $creation_date
 * @property string $change_date
 * @property string $first_name
 * @property string $last_name
 * @property string $nick_name
 * @property string $email
 * @property integer $gender
 * @property string $avatar
 * @property string $password
 * @property string $salt
 * @property integer $status
 * @property integer $access_level
 * @property string $last_visit
 * @property string $registration_date
 * @property string $registration_ip
 * @property string $activation_ip
 */
class User extends CActiveRecord
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    const GENDER_THING = 0;

    const STATUS_ACTIVE = 1;
    const STATUS_BLOCK = 0;

    const ACCESS_LEVEL_USER = 0;
    const ACCESS_LEVEL_ADMIN = 1;


    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user}}';
    }

    public function validatePassword($password)
    {
        if ($this->password === Registration::model()->hashPassword($password, $this->salt))
        {
            return true;
        }
        return false;
    }

    public function getAccessLevel()
    {
        $data = $this->getAccessLevelsList();
        return array_key_exists($this->access_level, $data)
            ? $data[$this->access_level]
            : Yii::t('user', 'ммм...такого доступа нет');
    }

    public function getAccessLevelsList()
    {
        return array(
            self::ACCESS_LEVEL_ADMIN => Yii::t('user', 'Администратор'),
            self::ACCESS_LEVEL_USER => Yii::t('user', 'Пользователь')
        );
    }


    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => Yii::t('user', 'Активен'),
            self::STATUS_BLOCK => Yii::t('user', 'Заблокирован'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data) ? $data[$this->status]
            : Yii::t('user', 'ммм...статуса такого нет');
    }


    public function getGendersList()
    {
        return array(
            self::GENDER_FEMALE => Yii::t('user', 'женский'),
            self::GENDER_MALE => Yii::t('user', 'мужской'),
            self::GENDER_THING => Yii::t('user', 'неизвестно')
        );
    }

    public function getGender()
    {
        $data = $this->getGendersList();
        return array_key_exists($this->gender, $data) ? $data[$this->gender]
            : Yii::t('user', 'ммм...пола такого нет');
    }

    /**
     * Returns the static model of the specified AR class.
     * @return User the static model class
     */
    public static function model($className = __CLASS__)
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
            array('nick_name, email, password', 'required'),
            array('gender, status, access_level, use_gravatar', 'numerical', 'integerOnly' => true),
            array('first_name, last_name, nick_name, email', 'length', 'max' => 150),
            array('password, salt', 'length', 'max' => 32),
            array('registration_ip, activation_ip, registration_date', 'length', 'max' => 20),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('user', 'Данный email уже используется другим пользователем')),
            array('nick_name', 'unique', 'message' => Yii::t('user', 'Данный ник уже используется другим пользователем')),
            array('avatar', 'file', 'types' => implode(',', Yii::app()->getModule('user')->avatarExtensions), 'maxSize' => Yii::app()->getModule('user')->avatarMaxSize, 'allowEmpty' => true),
            array('use_gravatar', 'in', 'range' => array(0, 1)),
            array('id, creation_date, change_date, first_name, last_name, nick_name, email, gender, avatar, password, salt, status, access_level, last_visit, registration_date, registration_ip, activation_ip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('user', 'Id'),
            'creation_date' => Yii::t('user', 'Дата активации'),
            'change_date' => Yii::t('user', 'Дата изменения'),
            'first_name' => Yii::t('user', 'Имя'),
            'last_name' => Yii::t('user', 'Фамилия'),
            'nick_name' => Yii::t('user', 'Ник'),
            'email' => Yii::t('user', 'Email'),
            'gender' => Yii::t('user', 'Пол'),
            'password' => Yii::t('user', 'Пароль'),
            'salt' => Yii::t('user', 'Соль'),
            'status' => Yii::t('user', 'Статус'),
            'access_level' => Yii::t('user', 'Уровень доступа'),
            'last_visit' => Yii::t('user', 'Последний визит'),
            'registration_date' => Yii::t('user', 'Дата регистрации'),
            'registration_ip' => Yii::t('user', 'Ip регистрации'),
            'activation_ip' => Yii::t('user', 'Ip активации'),
            'avatar' => Yii::t('user', 'Аватар'),
            'use_gravatar' => Yii::t('user', 'Граватар'),
        );
    }


    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);

        $criteria->compare('creation_date', $this->creation_date, true);

        $criteria->compare('change_date', $this->change_date, true);

        $criteria->compare('first_name', $this->first_name, true);

        $criteria->compare('last_name', $this->last_name, true);

        $criteria->compare('nick_name', $this->nick_name, true);

        $criteria->compare('email', $this->email, true);

        $criteria->compare('gender', $this->gender);

        $criteria->compare('password', $this->password, true);

        $criteria->compare('salt', $this->salt, true);

        $criteria->compare('status', $this->status);

        $criteria->compare('access_level', $this->access_level);

        $criteria->compare('last_visit', $this->last_visit, true);

        $criteria->compare('registration_date', $this->registration_date, true);

        $criteria->compare('registration_ip', $this->registration_ip, true);

        $criteria->compare('activation_ip', $this->activation_ip, true);

        return new CActiveDataProvider('User', array(
                                                    'criteria' => $criteria,
                                               ));
    }


    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $this->last_visit = $this->creation_date = $this->change_date = new CDbExpression('NOW()');
                
                $this->activation_ip = Yii::app()->request->userHostAddress;
            }

            return true;
        }

        return false;
    }


    public function scopes()
    {
        return array(
            'active' => array('condition' => 'status=' . self::STATUS_ACTIVE),
            'blocked' => array('condition' => 'status=' . self::STATUS_BLOCK),
            'admin' => array('condition' => 'access_level=' . self::ACCESS_LEVEL_ADMIN),
            'user' => array('condition' => 'access_level=' . self::ACCESS_LEVEL_USER),
        );
    }

    // проверить уникальность логина по двум таблицам
    public function checkNickNameUnique($nick_name)
    {
        $nick_name = trim(strtolower($nick_name));

        // проверим по таблице Registration
        $registration = Registration::model()->find('nick_name = :nick_name', array(':nick_name' => $nick_name));

        if (!is_null($registration))
        {
            return false;
        }

        // проверим по табличке User
        $user = User::model()->find('nick_name = :nick_name', array(':nick_name' => $nick_name));

        return is_null($user) ? true : false;
    }

    // проверить уникальность логина по двум таблицам
    public function checkEmailUnique($email)
    {
        $email = trim(strtolower($email));

        // проверим по таблице Registration
        $registration = Registration::model()->find('email = :email', array(':email' => $email));

        if (!is_null($registration))
        {
            return false;
        }

        // проверим по табличке User
        $user = User::model()->find('email = :email', array(':email' => $email));

        return is_null($user) ? true : false;
    }

    public function getAvatar($htmlOptions = null)
    {
        if ($this->use_gravatar && $this->email)
        {
            return CHtml::image('http://gravatar.com/avatar/' . md5($this->email), $this->nick_name, $htmlOptions);
        }
        elseif ($this->avatar)
        {
            return CHtml::image($this->avatar, $this->nick_name, $htmlOptions);
        }

        return '';
    }

    public function getFullName($separator = ' ')
    {
        return $this->first_name || $this->last_name
            ? $this->last_name . $separator . $this->first_name : $this->nick_name;
    }

    public function createAccount($nick_name, $email, $params = null, $password = null, $salt = null)
    {
        $user = new User();

        $salt = is_null($salt) ? Registration::model()->generateSalt() : $salt;

        $password = is_null($password) ? Registration::model()->generateRandomPassword() : $password;

        $user->setAttributes(array(
                                  'nick_name' => $nick_name,
                                  'email' => $email,
                                  'salt' => $salt,
                                  'password' => Registration::model()->hashPassword($password, $salt),
                                  'registration_date' => new CDbExpression('NOW()'),
                                  'registration_ip' => Yii::app()->request->userHostAddress
                             ));

        if (is_array($params) && count($params))
        {
            foreach ($params as $key => $value)
            {
                $user->$key = $value;
            }
        }
		
		$user->save();

        return $user;
    }    
}
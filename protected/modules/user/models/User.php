<?php

/**
 * This is the model class for table "{{user_user}}".
 *
 * The followings are the available columns in table '{{user_user}}':
 * @property integer $id
 * @property string $creation_date
 * @property string $change_date
 * @property string $first_name
 * @property string $middle_name
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
class User extends YModel
{
    const GENDER_THING  = 0;
    const GENDER_MALE   = 1;
    const GENDER_FEMALE = 2;

    const STATUS_BLOCK      = 0;
    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 2;

    const EMAIL_CONFIRM_NO  = 0;
    const EMAIL_CONFIRM_YES = 1;

    const ACCESS_LEVEL_USER  = 0;
    const ACCESS_LEVEL_ADMIN = 1;

    private $_oldAccess_level;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user_user}}';
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
        $module = Yii::app()->getModule('user');

        return array(
            array('birth_date, site, about, location, online_status, nick_name, first_name, last_name, middle_name, email', 'filter', 'filter' => 'trim'),
            array('birth_date, site, about, location, online_status, nick_name, first_name, last_name, middle_name, email', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('nick_name, email, password', 'required'),
            array('first_name, last_name, middle_name, nick_name, email', 'length', 'max' => 50),
            array('password, salt, activate_key', 'length', 'max' => 32),
            array('site', 'length', 'max' => 100),
            array('about', 'length', 'max' => 300),
            array('location, online_status', 'length', 'max' => 150),
            array('registration_ip, activation_ip, registration_date', 'length', 'max' => 20),
            array('gender, status, access_level, use_gravatar, email_confirm', 'numerical', 'integerOnly' => true),
            array('email_confirm', 'in', 'range' => array_keys($this->emailConfirmStatusList)),
            array('use_gravatar', 'in', 'range' => array(0, 1)),
            array('gender', 'in', 'range' => array_keys($this->gendersList)),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('access_level', 'in', 'range' => array_keys($this->getAccessLevelsList())),
            array('nick_name', 'match', 'pattern' => '/^[A-Za-z0-9_-]{2,50}$/', 'message' => Yii::t('UserModule.user', 'Неверный формат поля "{attribute}" допустимы только буквы и цифры, от 2 до 20 символов')),
            array('site', 'url', 'allowEmpty' => true),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('UserModule.user', 'Данный email уже используется другим пользователем')),
            array('nick_name', 'unique', 'message' => Yii::t('UserModule.user', 'Данный ник уже используется другим пользователем')),
            array('avatar', 'file', 'types' => implode(',', $module->avatarExtensions), 'maxSize' => $module->avatarMaxSize, 'allowEmpty' => true),
            array('id, creation_date, change_date, middle_name, first_name, last_name, nick_name, email, gender, avatar, password, salt, status, access_level, last_visit, registration_date, registration_ip, activation_ip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'                => Yii::t('UserModule.user', 'Id'),
            'creation_date'     => Yii::t('UserModule.user', 'Дата активации'),
            'change_date'       => Yii::t('UserModule.user', 'Дата изменения'),
            'first_name'        => Yii::t('UserModule.user', 'Имя'),
            'last_name'         => Yii::t('UserModule.user', 'Фамилия'),
            'middle_name'       => Yii::t('UserModule.user', 'Отчество'),
            'nick_name'         => Yii::t('UserModule.user', 'Ник'),
            'email'             => Yii::t('UserModule.user', 'Email'),
            'gender'            => Yii::t('UserModule.user', 'Пол'),
            'password'          => Yii::t('UserModule.user', 'Пароль'),
            'salt'              => Yii::t('UserModule.user', 'Соль'),
            'status'            => Yii::t('UserModule.user', 'Статус'),
            'access_level'      => Yii::t('UserModule.user', 'Доступ'),
            'last_visit'        => Yii::t('UserModule.user', 'Последний визит'),
            'registration_date' => Yii::t('UserModule.user', 'Дата регистрации'),
            'registration_ip'   => Yii::t('UserModule.user', 'Ip регистрации'),
            'activation_ip'     => Yii::t('UserModule.user', 'Ip активации'),
            'activate_key'      => Yii::t('UserModule.user', 'Код активации'),
            'avatar'            => Yii::t('UserModule.user', 'Аватар'),
            'use_gravatar'      => Yii::t('UserModule.user', 'Граватар'),
            'email_confirm'     => Yii::t('UserModule.user', 'Email подтвержден'),
            'birth_date'        => Yii::t('UserModule.user', 'День рождения'),
            'site'              => Yii::t('UserModule.user', 'Сайт/блог'),
            'location'          => Yii::t('UserModule.user', 'Расположение'),
            'about'             => Yii::t('UserModule.user', 'О себе'),
        );
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('first_name', $this->first_name, true);
        $criteria->compare('middle_name', $this->first_name, true);
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

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function afterFind()
    {
        $this->_oldAccess_level = $this->access_level;
    }

    public function beforeSave()
    {
        $this->change_date = new CDbExpression(
            Yii::app()->db->schema instanceof CSqliteSchema
            ? 'DATETIME("now")'
            :'NOW()'
        );

        if (!$this->isNewRecord
            && $this->admin()->count() == 1
            && $this->_oldAccess_level == self::ACCESS_LEVEL_ADMIN
            && ($this->access_level == self::ACCESS_LEVEL_USER || $this->status != self::STATUS_ACTIVE)
        ) {
            return false;
        }

        if ($this->isNewRecord) {
            $this->registration_date = $this->creation_date = $this->change_date;
            $this->registration_ip   = $this->activation_ip = Yii::app()->request->userHostAddress;
            $this->activate_key      = $this->generateActivationKey();
        }

        if ($this->birth_date === '')
            unset($this->birth_date);

        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        if (User::model()->admin()->count() == 1 && $this->_oldAccess_level == self::ACCESS_LEVEL_ADMIN)
            return false;

        return parent::beforeDelete();
    }

    public function scopes()
    {
        return array(
            'active'       => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_ACTIVE),
            ),
            'blocked'      => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_BLOCK),
            ),
            'notActivated' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_NOT_ACTIVE),
            ),
            'admin'        => array(
                'condition' => 'access_level = :access_level',
                'params'    => array(':access_level' => self::ACCESS_LEVEL_ADMIN),
            ),
            'user'         => array(
                'condition' => 'access_level = :access_level',
                'params'    => array(':access_level' => self::ACCESS_LEVEL_USER),
            ),
        );
    }

    public function validatePassword($password)
    {
        if ($this->password === $this->hashPassword($password, $this->salt))
            return true;
        return false;
    }

    public function getAccessLevelsList()
    {
        return array(
            self::ACCESS_LEVEL_ADMIN => Yii::t('UserModule.user', 'Администратор'),
            self::ACCESS_LEVEL_USER  => Yii::t('UserModule.user', 'Пользователь'),
        );
    }

    public function getAccessLevel()
    {
        $data = $this->getAccessLevelsList();
        return isset($data[$this->access_level]) ? $data[$this->access_level] : Yii::t('UserModule.user', '*нет*');
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE     => Yii::t('UserModule.user', 'Активен'),
            self::STATUS_BLOCK      => Yii::t('UserModule.user', 'Заблокирован'),
            self::STATUS_NOT_ACTIVE => Yii::t('UserModule.user', 'Не активирован'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('UserModule.user', 'статус не определен');
    }

    public function getGendersList()
    {
        return array(
            self::GENDER_FEMALE => Yii::t('UserModule.user', 'женский'),
            self::GENDER_MALE   => Yii::t('UserModule.user', 'мужской'),
            self::GENDER_THING  => Yii::t('UserModule.user', 'не указан'),
        );
    }

    public function getGender()
    {
        $data = $this->gendersList;
        return isset($data[$this->gender]) ? $data[$this->gender] : Yii::t('UserModule.user', 'не указан');
    }

    public function getEmailConfirmStatusList()
    {
        return array(
            self::EMAIL_CONFIRM_YES => Yii::t('UserModule.user', 'Да'),
            self::EMAIL_CONFIRM_NO  => Yii::t('UserModule.user', 'Нет'),
        );
    }

    public function getEmailConfirmStatus()
    {
        $data = $this->emailConfirmStatusList;
        return isset($data[$this->email_confirm]) ? $data[$this->email_confirm] : Yii::t('UserModule.user', '*неизвестно*');
    }

    public function hashPassword($password, $salt)
    {
        return md5($salt . $password);
    }

    public function generateSalt()
    {
        return md5(uniqid('', true) . time());
    }

    public function generateRandomPassword($length = null)
    {
        return substr(md5(uniqid(mt_rand(), true) . time()), 0, $length?$length:32);
    }

    public function generateActivationKey()
    {
        return md5(time() . $this->email . uniqid());
    }

    /**
     * Получить аватарку пользователя в виде тега IMG.
     * @param array $htmlOptions HTML-опции для создаваемого тега
     * @param int $size требуемый размер аватарки в пикселях
     * @return string код аватарки
     */

    //@TODO подумать не лучше ли возвращать CHtml::image а не просто строку
    public function getAvatar($size = 64, $htmlOptions = array())
    {
        $size = intval($size);
        $size || ($size = 32);

        if (!is_array($htmlOptions))
            throw new CException(Yii::t('UserModule.user', "htmlOptions must be array or not specified!"));

        isset($htmlOptions['width']) || ($htmlOptions['width'] = $size);
        isset($htmlOptions['height']) || ($htmlOptions['height'] = $size);

        // если это граватар
        if ($this->use_gravatar && $this->email)
            return 'http://gravatar.com/avatar/' . md5($this->email) . "?d=mm&s=" . $size;
        else if ($this->avatar)
        {
            $avatarsDir = Yii::app()->getModule('user')->avatarsDir;
            $basePath   = Yii::app()->basePath . "/../" . $avatarsDir;
            $sizedFile  = str_replace(".", "_" . $size . ".", $this->avatar);

            // Посмотрим, есть ли у нас уже нужный размер? Если есть - используем его
            if (file_exists($basePath . "/" . $sizedFile))
                return Yii::app()->baseUrl . $avatarsDir . "/" . $sizedFile;

            if (file_exists($basePath . "/" . $this->avatar))
            {
                // Есть! Можем сделать нужный размер
                $image = Yii::app()->image->load($basePath . "/" . $this->avatar);
                if ($image->ext != 'gif' || $image->config['driver'] == "ImageMagick")
                    $image->resize($size, $size, CImage::AUTO)
                          ->crop($size, $size)
                          ->quality(75)
                          ->sharpen(20)
                          ->save($basePath . "/" . $sizedFile);
                else
                    @copy($basePath . "/" . $this->avatar, $basePath . "/" . $sizedFile);

                return Yii::app()->baseUrl . $avatarsDir . "/" . $sizedFile;
            }
        }
        // Нету аватарки, печалька :(
        return Yii::app()->request->baseUrl . Yii::app()->getModule('user')->defaultAvatar;
    }

    public function getFullName($separator = ' ')
    {
        return ($this->first_name || $this->last_name)
            ? $this->last_name . $separator . $this->first_name . ($this->middle_name ? ($separator . $this->middle_name) : "")
            : $this->nick_name;
    }

    public function createAccount(
        $nick_name,
        $email,
        $password     = null,
        $salt         = null,
        $status       = self::STATUS_NOT_ACTIVE,
        $emailConfirm = self::EMAIL_CONFIRM_NO,
        $first_name   = '',
        $last_name    = ''
    )
    {
        $salt = ($salt === NULL) ? $this->generateSalt() : $salt;
        $password = ($password === NULL) ? $this->generateRandomPassword() : $password;

        $this->setAttributes(array(
            'nick_name'         => $nick_name,
            'first_name'        => $first_name,
            'last_name'         => $last_name,
            'salt'              => $salt,
            'password'          => $this->hashPassword($password, $salt),
            'registration_date' => YDbMigration::expression('NOW()'),
            'registration_ip'   => Yii::app()->request->userHostAddress,
            'activation_ip'     => Yii::app()->request->userHostAddress,
            'status'            => $status,
            'email_confirm'     => $emailConfirm,
        ));

        // если не определен емэйл то генерим уникальный
        $setemail = empty($email);
        $this->email = $setemail ? 'user-' . $this->generateSalt() . '@' . $_SERVER['HTTP_HOST'] : $email;

        $this->save(false);

        // для красоты
        if ($setemail)
        {
            $this->email = "user-{$this->id}@{$_SERVER['HTTP_HOST']}";
            $this->update(array('email'));
        }
    }

    public function changePassword($password)
    {
        $this->password = $this->hashPassword($password, $this->salt);
        return $this->update(array('password'));
    }

    public function activate()
    {
        $this->activation_ip    = Yii::app()->request->userHostAddress;
        $this->status           = self::STATUS_ACTIVE;
        $this->email_confirm    = self::EMAIL_CONFIRM_YES;
        return $this->save();
    }

    public function needActivation()
    {
        return $this->status == User::STATUS_NOT_ACTIVE
            ? true
            : false;
    }
}
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
 * @property integer $email_confirm
 * @property integer $use_gravatar
 * @property string $online_status
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
            array('registration_ip, activation_ip, registration_date', 'length', 'max' => 50),
            array('gender, status, access_level, use_gravatar, email_confirm', 'numerical', 'integerOnly' => true),
            array('email_confirm', 'in', 'range' => array_keys($this->getEmailConfirmStatusList())),
            array('use_gravatar', 'in', 'range' => array(0, 1)),
            array('gender', 'in', 'range' => array_keys($this->getGendersList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('access_level', 'in', 'range' => array_keys($this->getAccessLevelsList())),
            array('nick_name', 'match', 'pattern' => '/^[A-Za-z0-9_-]{2,50}$/', 'message' => Yii::t('UserModule.user', 'Bad field format for "{attribute}". You can use only letters and digits from 2 to 20 symbols')),
            array('site', 'url', 'allowEmpty' => true),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('UserModule.user', 'This email already use by another user')),
            array('nick_name', 'unique', 'message' => Yii::t('UserModule.user', 'This nickname already use by another user')),
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
            'creation_date'     => Yii::t('UserModule.user', 'Activated at'),
            'change_date'       => Yii::t('UserModule.user', 'Updated at'),
            'first_name'        => Yii::t('UserModule.user', 'Name'),
            'last_name'         => Yii::t('UserModule.user', 'Last name'),
            'middle_name'       => Yii::t('UserModule.user', 'Family name'),
            'nick_name'         => Yii::t('UserModule.user', 'Nick'),
            'email'             => Yii::t('UserModule.user', 'Email'),
            'gender'            => Yii::t('UserModule.user', 'Sex'),
            'password'          => Yii::t('UserModule.user', 'Password'),
            'salt'              => Yii::t('UserModule.user', 'Salt'),
            'status'            => Yii::t('UserModule.user', 'Status'),
            'access_level'      => Yii::t('UserModule.user', 'Access'),
            'last_visit'        => Yii::t('UserModule.user', 'Last visit'),
            'registration_date' => Yii::t('UserModule.user', 'Register date'),
            'registration_ip'   => Yii::t('UserModule.user', 'Register Ip'),
            'activation_ip'     => Yii::t('UserModule.user', 'Activation Ip'),
            'activate_key'      => Yii::t('UserModule.user', 'Activation code'),
            'avatar'            => Yii::t('UserModule.user', 'Avatar'),
            'use_gravatar'      => Yii::t('UserModule.user', 'Gravatar'),
            'email_confirm'     => Yii::t('UserModule.user', 'Email was confirmed'),
            'birth_date'        => Yii::t('UserModule.user', 'Birthday'),
            'site'              => Yii::t('UserModule.user', 'Site/blog'),
            'location'          => Yii::t('UserModule.user', 'Location'),
            'about'             => Yii::t('UserModule.user', 'About yourself'),
            'online_status'     => Yii::t('UserModule.user', 'Status')
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
        $criteria->compare('email_confirm', $this->email_confirm, true);
        $criteria->compare('online_status', $this->online_status, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    public function afterFind()
    {
        $this->_oldAccess_level = $this->access_level;
    }

    public function beforeSave()
    {
        $this->change_date = new CDbExpression('NOW()');

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

        if ($this->birth_date === '') {
            unset($this->birth_date);
        }

        return parent::beforeSave();
    }

    public function beforeDelete()
    {
        if (User::model()->admin()->count() == 1 && $this->_oldAccess_level == self::ACCESS_LEVEL_ADMIN){
            return false;
        }

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
        if ($this->password === $this->hashPassword($password, $this->salt)) {
            return true;
        }
        return false;
    }

    public function getAccessLevelsList()
    {
        return array(
            self::ACCESS_LEVEL_ADMIN => Yii::t('UserModule.user', 'Administrator'),
            self::ACCESS_LEVEL_USER  => Yii::t('UserModule.user', 'User'),
        );
    }

    public function getAccessLevel()
    {
        $data = $this->getAccessLevelsList();
        return isset($data[$this->access_level]) ? $data[$this->access_level] : Yii::t('UserModule.user', '*no*');
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE     => Yii::t('UserModule.user', 'Active'),
            self::STATUS_BLOCK      => Yii::t('UserModule.user', 'Blocked'),
            self::STATUS_NOT_ACTIVE => Yii::t('UserModule.user', 'Not activated'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('UserModule.user', 'status is not set');
    }

    public function getGendersList()
    {
        return array(
            self::GENDER_FEMALE => Yii::t('UserModule.user', 'female'),
            self::GENDER_MALE   => Yii::t('UserModule.user', 'male'),
            self::GENDER_THING  => Yii::t('UserModule.user', 'not set'),
        );
    }

    public function getGender()
    {
        $data = $this->getGendersList();
        return isset($data[$this->gender]) ? $data[$this->gender] : Yii::t('UserModule.user', 'not set');
    }

    public function getEmailConfirmStatusList()
    {
        return array(
            self::EMAIL_CONFIRM_YES => Yii::t('UserModule.user', 'Yes'),
            self::EMAIL_CONFIRM_NO  => Yii::t('UserModule.user', 'No'),
        );
    }

    public function getEmailConfirmStatus()
    {
        $data = $this->getEmailConfirmStatusList();
        return isset($data[$this->email_confirm]) ? $data[$this->email_confirm] : Yii::t('UserModule.user', '*unknown*');
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
     * Получить аватарку пользователя в виде тега IMG
     *
     * @param array $htmlOptions HTML-опции для создаваемого тега
     * @param int $size требуемый размер аватарки в пикселях
     *
     * @throws CException
     * @return string код аватарки
     */

    //@TODO подумать не лучше ли возвращать CHtml::image а не просто строку
    public function getAvatar($size = 64, $htmlOptions = array())
    {
        $size = (int)$size;
        $size || ($size = 32);

        if (!is_array($htmlOptions)) {
            throw new CException(Yii::t('UserModule.user', "htmlOptions must be array or not specified!"));
        }

        isset($htmlOptions['width']) || ($htmlOptions['width'] = $size);
        isset($htmlOptions['height']) || ($htmlOptions['height'] = $size);

        // если это граватар
        if ($this->use_gravatar && $this->email) {
            return 'http://gravatar.com/avatar/' . md5($this->email) . "?d=mm&s=" . $size;
        } else if ($this->avatar){
            $avatarsDir = Yii::app()->getModule('user')->avatarsDir;
            $uploadPath = Yii::app()->getModule('yupe')->uploadPath;
            $basePath   = Yii::app()->getModule('user')->getUploadPath();
            $sizedFile  = str_replace(".", "_" . $size . ".", $this->avatar);

            // Посмотрим, есть ли у нас уже нужный размер? Если есть - используем его
            if (file_exists($basePath . "/" . $sizedFile)) {
                return Yii::app()->request->baseUrl . '/' . $uploadPath . '/'. $avatarsDir . "/" . $sizedFile;
            }

            if (file_exists($basePath . "/" . $this->avatar)){
                // Есть! Можем сделать нужный размер
                $image = Yii::app()->image->load($basePath . "/" . $this->avatar);
                if ($image->ext != 'gif' || $image->config['driver'] == "ImageMagick") {
                    $image->resize($size, $size, CImage::WIDTH)
                          ->crop($size, $size)
                          ->quality(85)
                          ->sharpen(15)
                          ->save($basePath . "/" . $sizedFile);
                }else {
                    @copy($basePath . "/" . $this->avatar, $basePath . "/" . $sizedFile);
                }

                return Yii::app()->request->baseUrl . '/'. $uploadPath . '/' . $avatarsDir . "/" . $sizedFile;
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
            'registration_date' => new CDbExpression('NOW()'),
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

    public function confirmEmail()
    {
        $this->email_confirm = self::EMAIL_CONFIRM_YES;
        return $this->save();
    }

    public function needEmailConfirm()
    {
        return $this->email_confirm == self::EMAIL_CONFIRM_YES ? false : true;
    }

    public function needActivation()
    {
        return $this->status == User::STATUS_NOT_ACTIVE
            ? true
            : false;
    }
    
    /**
     * Устанавливает новый аватар
     *
     * @param CUploadedFile $uploadedFile
     * @throws CException
     */
    public function changeAvatar(CUploadedFile $uploadedFile) {        
        $basePath = Yii::app()->getModule('user')->getUploadPath();

        //создаем каталог для аватарок, если не существует
        if(!is_dir($basePath) && !@mkdir($basePath,0755,true)) {
            throw new CException(Yii::t('UserModule.user','It is not possible to create directory for avatars!'));
        }

        $filename = $this->id.'_'.time() . '.' . $uploadedFile->extensionName;

        if($this->avatar) {
            //remove old resized avatars
            if(file_exists($basePath . $filename)){
                @unlink($basePath . $filename);
            }

            foreach (glob($basePath . $this->id . '_*.*') as $oldThumbnail) {
                @unlink($oldThumbnail);
            }
        }

        if(!$uploadedFile->saveAs($basePath . $filename)) {
            throw new CException(Yii::t('UserModule.user','It is not possible to save avatar!'));
        }

        $this->avatar = $filename;
    }
}
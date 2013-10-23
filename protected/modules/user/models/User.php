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

use yupe\widgets\CustomGridView;

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
    public $use_gravatar = false;

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
            array('gender, status, access_level, use_gravatar', 'numerical', 'integerOnly' => true),
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
     * Массив связей:
     * 
     * @return array
     */
    public function relations()
    {
        return array(
            // Токен активации пользователя,
            // содержит:
            // - дату регистрации
            // - дату активации (может измениться если изменить статус пользователя)
            // - статус активации
            // - ip с какого была произведена активация
            // - токен активации
            'reg' => array(
                self::HAS_ONE, 'UserToken', 'user_id', 'on' => 'reg.type = :type AND reg.status != :status', 'params' => array(
                    ':type'   => UserToken::TYPE_ACTIVATE,
                    ':status' => UserToken::STATUS_FAIL,
                ),
            ),
            // Все токены пользователя:
            'tokens' => array(
                self::HAS_MANY, 'UserToken', 'user_id'
            )
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

    /**
     * Проверка активации пользователя:
     * 
     * @return boolean
     */
    public function getIsActivated()
    {
        return $this->reg instanceof UserToken
            && $this->reg->status === UserToken::STATUS_ACTIVATE;
    }

    public function search()
    {
        $criteria = new CDbCriteria;

        $ips = array();

        empty($this->activation_ip) || array_push($ips, $this->activation_ip);
        empty($this->registration_ip) || array_push($ips, $this->registration_ip);

        if (($data = Yii::app()->getRequest()->getParam('UserToken')) !== null || !empty($ips)) {
            $reg = new UserToken;
            $reg->setAttributes($data);

            $criteria->with = array('reg');
            $criteria->togather = true;

            if (!empty($reg->created) && strlen($reg->created) == 10) {
                $criteria->addBetweenCondition('created', $reg->created . ' 00:00:00', $reg->created . ' 23:59:59');
            }

            if (!empty($reg->updated) && strlen($reg->updated) == 10) {
                $criteria->addBetweenCondition('updated', $reg->updated . ' 00:00:00', $reg->updated . ' 23:59:59');
            }

            $criteria->addInCondition('reg.ip', $ips);
        }

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.change_date', $this->change_date, true);
        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('t.middle_name', $this->first_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('t.nick_name', $this->nick_name, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.gender', $this->gender);
        $criteria->compare('t.password', $this->password, true);
        $criteria->compare('t.salt', $this->salt, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.access_level', $this->access_level);
        $criteria->compare('t.last_visit', $this->last_visit, true);
        $criteria->compare('t.email_confirm', $this->email_confirm, true);
        $criteria->compare('t.online_status', $this->online_status, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * Метод после поиска:
     * 
     * @return void
     */
    public function afterFind()
    {
        $this->_oldAccess_level = $this->access_level;
        
        // Если пустое поле аватар - автоматически
        // включаем граватар:
        $this->use_gravatar = empty($this->avatar);

        return parent::afterFind();
    }

    public function beforeSave()
    {
        $this->change_date = new CDbExpression('NOW()');

        if (!$this->isNewRecord
            && $this->admin()->count() == 1
            && $this->_oldAccess_level == self::ACCESS_LEVEL_ADMIN
            && ($this->access_level == self::ACCESS_LEVEL_USER || $this->status != self::STATUS_ACTIVE)
        ) {
            $this->addError(
                'access_level',
                Yii::t('UserModule.user', 'You can\'t make this changes!')
            );
            return false;
        }

        if ($this->getIsNewRecord() === false && $this->reg instanceof UserToken && $this->status !== self::STATUS_BLOCK) {
            $this->reg->status = $this->status == self::STATUS_ACTIVE
                ? UserToken::STATUS_ACTIVATE
                : null;

            $this->reg->save();
        } elseif ($this->getIsNewRecord() === false && ($this->reg instanceof UserToken) === false) {
            UserToken::newActivate(
                $this, $this->status == self::STATUS_ACTIVE
                            ? UserToken::STATUS_ACTIVATE
                            : null
            );
        }

        if ($this->birth_date === '') {
            unset($this->birth_date);
        }

        // Если используется граватар - удаляем текущие аватарки:
        $this->use_gravatar === false || $this->removeOldAvatar();

        if ($this->getIsNewRecord()) {
            $this->creation_date = new CDbExpression('NOW()');
            $this->activate_key = "empty";
        }

        return parent::beforeSave();
    }

    /**
     * Метод после сохранения:
     * - если новый пользователь, то создаём токен активации.
     * 
     * @return void
     */
    public function afterSave()
    {
        if ($this->getIsNewRecord() === true) {
            UserToken::newActivate(
                $this, $this->status == self::STATUS_ACTIVE
                            ? UserToken::STATUS_ACTIVATE
                            : null
            );
        }

        return parent::afterSave();
    }

    public function beforeDelete()
    {
        if (User::model()->admin()->count() == 1 && $this->_oldAccess_level == self::ACCESS_LEVEL_ADMIN){
            $this->addError(
                'access_level',
                Yii::t('UserModule.user', 'You can\'t make this changes!')
            );
            
            return false;
        }

        $transaction = Yii::app()->getDb()->beginTransaction();

        foreach ($this->tokens as $token) {
            // Если нельзя удалить какой-то токен
            // делаем rollBack и сообщаем о проблеме:
            if (false === $token->delete()) {

                $transaction->rollBack();

                $errors = array();

                foreach ((array)$token->getErrors() as &$value) {
                    $errors[] = implode("\n", $value);
                }
                
                throw new Exception(
                    implode("\n", $errors)
                );
            }
        }

        $transaction->commit();

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

    /**
     * Получить аватарку пользователя в виде тега IMG
     *
     * @param int $size требуемый размер аватарки в пикселях
     *
     * @return string код аватарки
     */

    //@TODO подумать не лучше ли возвращать CHtml::image а не просто строку
    public function getAvatar($size = 64)
    {
        $size = (int)$size;
        $size || ($size = 32);

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
                return Yii::app()->getRequest()->baseUrl . '/' . $uploadPath . '/'. $avatarsDir . "/" . $sizedFile;
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
                } else {
                    @copy($basePath . "/" . $this->avatar, $basePath . "/" . $sizedFile);
                }

                return Yii::app()->getRequest()->baseUrl . '/'. $uploadPath . '/' . $avatarsDir . "/" . $sizedFile;
            }
        }
        // Нету аватарки, печалька :(
        return Yii::app()->getRequest()->baseUrl . Yii::app()->getModule('user')->defaultAvatar;
    }

    /**
     * Изменение статуса в gridView:
     * 
     * @param CustomGridView $grid - gridView
     * 
     * @return mixed
     */
    public function changeStatus(CustomGridView $grid)
    {
        return $grid->returnBootstrapStatusHtml(
            $this, "status", "ChangeableStatus"
        );
    }

    /**
     * Список доступных к изменению статусов:
     * заставлять пользователя проходить
     * активацию по 100 раз
     * 
     * @return array
     */
    public function getChangeableStatusList()
    {
        $statuses = $this->getStatusList();

        $status = $this->getIsActivated() === false
                ? self::STATUS_ACTIVE
                : self::STATUS_NOT_ACTIVE;

        unset($statuses[$status]);

        return $statuses;
    }

    /**
     * Получаем полное имя пользователя:
     * 
     * @param  string $separator - разделитель
     * 
     * @return string
     */
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
            'registration_ip'   => Yii::app()->getRequest()->userHostAddress,
            'activation_ip'     => Yii::app()->getRequest()->userHostAddress,
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
        if ($this->reg instanceof UserToken === false) {
            return UserToken::newActivate(
                $this, UserToken::STATUS_ACTIVATE
            );
        }

        $this->reg->status = UserToken::STATUS_ACTIVATE;
        $this->reg->ip = Yii::app()->getRequest()->getUserHostAddress();
        
        return $this->reg->save();
    }

    protected function removeOldAvatar()
    {
        $basePath = Yii::app()->getModule('user')->getUploadPath();

        if ($this->avatar) {
            //remove old resized avatars
            if(file_exists($basePath . $filename)){
                @unlink($basePath . $filename);
            }

            foreach (glob($basePath . $this->id . '_*.*') as $oldThumbnail) {
                @unlink($oldThumbnail);
            }
        }

        $this->avatar = null;
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

        $this->removeOldAvatar();

        if(!$uploadedFile->saveAs($basePath . $filename)) {
            throw new CException(Yii::t('UserModule.user','It is not possible to save avatar!'));
        }

        $this->avatar = $filename;
    }
}
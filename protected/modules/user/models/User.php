<?php

/**
 * This is the model class for table "{{user_user}}".
 *
 * The followings are the available columns in table '{{user_user}}':
 * @property integer $id
 * @property string  $change_date
 * @property string  $first_name
 * @property string  $middle_name
 * @property string  $last_name
 * @property string  $nick_name
 * @property string  $email
 * @property integer $gender
 * @property string  $avatar
 * @property string  $password
 * @property integer $status
 * @property integer $access_level
 * @property string  $last_visit
 * @property bollean $email_confirm
 * @property string  $registration_date
 *
 */
class User extends yupe\models\YModel
{
    const GENDER_THING = 0;
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    const STATUS_BLOCK = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_NOT_ACTIVE = 2;

    const EMAIL_CONFIRM_NO = 0;
    const EMAIL_CONFIRM_YES = 1;

    const ACCESS_LEVEL_USER = 0;
    const ACCESS_LEVEL_ADMIN = 1;

    private $_oldAccess_level;
    private $_oldStatus;
    public $use_gravatar = false;

    public $pageSize;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user_user}}';
    }

    /**
     * Returns the static model of the specified AR class.
     *
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
            array(
                'birth_date, site, about, location, nick_name, first_name, last_name, middle_name, email',
                'filter',
                'filter' => 'trim'
            ),
            array(
                'birth_date, site, about, location, nick_name, first_name, last_name, middle_name, email',
                'filter',
                'filter' => array($obj = new CHtmlPurifier(), 'purify')
            ),
            array('nick_name, email, hash', 'required'),
            array('first_name, last_name, middle_name, nick_name, email', 'length', 'max' => 50),
            array('hash', 'length', 'max' => 256),
            array('site', 'length', 'max' => 100),
            array('about', 'length', 'max' => 300),
            array('location', 'length', 'max' => 150),
            array('gender, status, access_level', 'numerical', 'integerOnly' => true),
            array(
                'nick_name',
                'match',
                'pattern' => '/^[A-Za-z0-9_-]{2,50}$/',
                'message' => Yii::t(
                        'UserModule.user',
                        'Bad field format for "{attribute}". You can use only letters and digits from 2 to 20 symbols'
                    )
            ),
            array('site', 'url', 'allowEmpty' => true),
            array('email', 'email'),
            array('email', 'unique', 'message' => Yii::t('UserModule.user', 'This email already use by another user')),
            array(
                'nick_name',
                'unique',
                'message' => Yii::t('UserModule.user', 'This nickname already use by another user')
            ),
            array(
                'avatar',
                'file',
                'types' => implode(',', $module->avatarExtensions),
                'maxSize' => $module->avatarMaxSize,
                'allowEmpty' => true
            ),
            array('email_confirm', 'in', 'range' => array_keys($this->getEmailConfirmStatusList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('registration_date', 'length', 'max' => 50),
            array(
                'id, change_date, middle_name, first_name, last_name, nick_name, email, gender, avatar, status, access_level, last_visit',
                'safe',
                'on' => 'search'
            ),
            array('birth_date', 'default', 'setOnEmpty' => true, 'value' => null),
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
            // Все токены пользователя:
            'tokens' => array(
                self::HAS_MANY,
                'UserToken',
                'user_id'
            )
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('UserModule.user', 'Id'),
            'creation_date' => Yii::t('UserModule.user', 'Activated at'),
            'change_date' => Yii::t('UserModule.user', 'Updated at'),
            'first_name' => Yii::t('UserModule.user', 'Name'),
            'last_name' => Yii::t('UserModule.user', 'Last name'),
            'middle_name' => Yii::t('UserModule.user', 'Family name'),
            'full_name' => Yii::t('UserModule.user', 'Full name'),
            'nick_name' => Yii::t('UserModule.user', 'Nick'),
            'email' => Yii::t('UserModule.user', 'Email'),
            'gender' => Yii::t('UserModule.user', 'Sex'),
            'password' => Yii::t('UserModule.user', 'Password'),
            'status' => Yii::t('UserModule.user', 'Status'),
            'access_level' => Yii::t('UserModule.user', 'Access'),
            'last_visit' => Yii::t('UserModule.user', 'Last visit'),
            'registration_date' => Yii::t('UserModule.user', 'Register date'),
            'registration_ip' => Yii::t('UserModule.user', 'Register Ip'),
            'activation_ip' => Yii::t('UserModule.user', 'Activation Ip'),
            'activate_key' => Yii::t('UserModule.user', 'Activation code'),
            'avatar' => Yii::t('UserModule.user', 'Avatar'),
            'use_gravatar' => Yii::t('UserModule.user', 'Gravatar'),
            'email_confirm' => Yii::t('UserModule.user', 'Email was confirmed'),
            'birth_date' => Yii::t('UserModule.user', 'Birthday'),
            'site' => Yii::t('UserModule.user', 'Site/blog'),
            'location' => Yii::t('UserModule.user', 'Location'),
            'about' => Yii::t('UserModule.user', 'About yourself'),
        );
    }


    /**
     * Проверка верификации почты:
     *
     * @return boolean
     */
    public function getIsVerifyEmail()
    {
        return $this->email_confirm;
    }


    /**
     * Строковое значение верификации почты пользователя:
     *
     * @return string
     */
    public function getIsVerifyEmailStatus()
    {
        return $this->getIsVerifyEmail()
            ? Yii::t('UserModule.user', 'Yes')
            : Yii::t('UserModule.user', 'No');
    }

    /**
     * Поиск пользователей по заданным параметрам:
     *
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.change_date', $this->change_date, true);
        if ($this->registration_date) {
            $criteria->compare('t.registration_date', date('Y-m-d', strtotime($this->registration_date)), true);
        }
        $criteria->compare('t.first_name', $this->first_name, true);
        $criteria->compare('t.middle_name', $this->first_name, true);
        $criteria->compare('t.last_name', $this->last_name, true);
        $criteria->compare('t.nick_name', $this->nick_name, true);
        $criteria->compare('t.email', $this->email, true);
        $criteria->compare('t.gender', $this->gender);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.access_level', $this->access_level);
        if ($this->last_visit) {
            $criteria->compare('t.last_visit', date('Y-m-d', strtotime($this->last_visit)), true);
        }
        $criteria->compare('t.email_confirm', $this->email_confirm);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => (int)$this->pageSize,
            ),
            'sort' => array(
                'defaultOrder' => 'id DESC',
            )
        ));
    }

    /**
     * Метод после поиска:
     *
     * @return void
     */
    public function afterFind()
    {
        $this->_oldAccess_level = $this->access_level;
        $this->_oldStatus = $this->status;
        // Если пустое поле аватар - автоматически
        // включаем граватар:
        $this->use_gravatar = empty($this->avatar);

        return parent::afterFind();
    }

    /**
     * Предвалидационные действия:
     *
     * @return void
     */
    public function beforeValidate()
    {
        $this->gender = $this->gender ? : self::GENDER_THING;

        return parent::beforeValidate();
    }

    /**
     * Метод выполняемый перед сохранением:
     *
     * @return void
     */
    public function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $this->registration_date = new CDbExpression('NOW()');
        } else {
            // Запрещаем действия, при которых администратор
            // может быть заблокирован или сайт останется без
            // администратора:
            if (
                $this->admin()->count() == 1
                && $this->_oldAccess_level === self::ACCESS_LEVEL_ADMIN
                && ((int)$this->access_level === self::ACCESS_LEVEL_USER || (int)$this->status !== self::STATUS_ACTIVE)
            ) {
                $this->addError(
                    'access_level',
                    Yii::t('UserModule.user', 'You can\'t make this changes!')
                );

                return false;
            }
        }
        if (!$this->birth_date) {
            $this->birth_date = null;
        }
        // Меняем дату изменения профиля:
        $this->change_date = new CDbExpression('NOW()');

        return parent::beforeSave();
    }


    /**
     * Метод перед удалением:
     *
     * @return void
     */
    public function beforeDelete()
    {
        if (User::model()->admin()->count() === 1 && $this->_oldAccess_level === self::ACCESS_LEVEL_ADMIN) {
            $this->addError(
                'access_level',
                Yii::t('UserModule.user', 'You can\'t make this changes!')
            );

            return false;
        }

        return parent::beforeDelete();
    }

    /**
     * Именнованные условия:
     *
     * @return array
     */
    public function scopes()
    {
        return array(
            'active' => array(
                'condition' => 't.status = :user_status',
                'params' => array(
                    ':user_status' => self::STATUS_ACTIVE
                ),
            ),
            'blocked' => array(
                'condition' => 'status = :blocked_status',
                'params' => array(':blocked_status' => self::STATUS_BLOCK),
            ),
            'admin' => array(
                'condition' => 'access_level = :access_level',
                'params' => array(':access_level' => self::ACCESS_LEVEL_ADMIN),
            ),
            'user' => array(
                'condition' => 'access_level = :access_level',
                'params' => array(':access_level' => self::ACCESS_LEVEL_USER),
            ),
        );
    }

    /**
     * Список текстовых значений ролей:
     *
     * @return array
     */
    public function getAccessLevelsList()
    {
        return array(
            self::ACCESS_LEVEL_ADMIN => Yii::t('UserModule.user', 'Administrator'),
            self::ACCESS_LEVEL_USER => Yii::t('UserModule.user', 'User'),
        );
    }

    /**
     * Получаем строковое значение роли
     * пользователя:
     *
     * @return string
     */
    public function getAccessLevel()
    {
        $data = $this->getAccessLevelsList();

        return isset($data[$this->access_level]) ? $data[$this->access_level] : Yii::t('UserModule.user', '*no*');
    }

    /**
     * Список возможных статусов пользователя:
     *
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE => Yii::t('UserModule.user', 'Active'),
            self::STATUS_BLOCK => Yii::t('UserModule.user', 'Blocked'),
            self::STATUS_NOT_ACTIVE => Yii::t('UserModule.user', 'Not activated'),
        );
    }

    /**
     * Получение строкового значения
     * статуса пользователя:
     *
     * @return string
     */
    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status])
            ? $data[$this->status]
            : Yii::t('UserModule.user', 'status is not set');
    }

    public function getEmailConfirmStatusList()
    {
        return array(
            self::EMAIL_CONFIRM_YES => Yii::t('UserModule.user', 'Yes'),
            self::EMAIL_CONFIRM_NO => Yii::t('UserModule.user', 'No'),
        );
    }

    public function getEmailConfirmStatus()
    {
        $data = $this->getEmailConfirmStatusList();

        return isset($data[$this->email_confirm]) ? $data[$this->email_confirm] : Yii::t(
            'UserModule.user',
            '*unknown*'
        );
    }

    /**
     * Список статусов половой принадлежности:
     *
     * @return array
     */
    public function getGendersList()
    {
        return array(
            self::GENDER_FEMALE => Yii::t('UserModule.user', 'female'),
            self::GENDER_MALE => Yii::t('UserModule.user', 'male'),
            self::GENDER_THING => Yii::t('UserModule.user', 'not set'),
        );
    }

    /**
     * Получаем строковое значение половой
     * принадлежности пользователя:
     *
     * @return string
     */
    public function getGender()
    {
        $data = $this->getGendersList();

        return isset($data[$this->gender])
            ? $data[$this->gender]
            : $data[self::GENDER_THING];
    }


    /**
     * Получить url аватарки пользователя:
     * -----------------------------------
     * Возвращаем именно url, так как на
     * фронте может быть любая вариация
     * использования, незачем ограничивать
     * разработчиков.
     *
     * @param int $size - требуемый размер аватарки в пикселях
     *
     * @return string - url аватарки
     */
    public function getAvatar($size = 64)
    {
        $size = (int)$size;

        // если это граватар
        if ($this->use_gravatar && $this->email) {
            return 'http://gravatar.com/avatar/' . md5($this->email) . "?d=mm&s=" . $size;
        }

        $userModule = Yii::app()->getModule('user');
        $avatar = $this->avatar;
        $path = $userModule->getUploadPath() . $avatar;

        if (!file_exists($path)) {
            $avatar = $userModule->defaultAvatar;
        }

        return Yii::app()->image->makeThumbnail(
            $avatar,
            $userModule->avatarsDir,
            $size,
            $size,
            \Imagine\Image\ImageInterface::THUMBNAIL_OUTBOUND
        );
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


    /**
     * Удаление старого аватара:
     *
     * @return void
     */
    protected function removeOldAvatar()
    {
        $basePath = Yii::app()->getModule('user')->getUploadPath();

        if ($this->avatar) {
            //remove old resized avatars
            if (file_exists($basePath . $this->avatar)) {
                @unlink($basePath . $this->avatar);
            }

            foreach (glob($basePath . '/thumbs/' . '*' . $this->avatar) as $thumb) {
                @unlink($thumb);
            }
        }

        $this->avatar = null;

        return true;
    }

    /**
     * Устанавливает новый аватар
     *
     * @param CUploadedFile $uploadedFile
     *
     * @throws CException
     *
     * @return void
     */
    public function changeAvatar(CUploadedFile $uploadedFile)
    {

        $basePath = Yii::app()->getModule('user')->getUploadPath();

        //создаем каталог для аватарок, если не существует
        if (!is_dir($basePath) && !@mkdir($basePath, 0755, true)) {
            throw new CException(Yii::t('UserModule.user', 'It is not possible to create directory for avatars!'));
        }

        $filename = $this->id . '_' . time() . '.' . $uploadedFile->extensionName;

        $this->removeOldAvatar();

        if (!$uploadedFile->saveAs($basePath . $filename)) {
            throw new CException(Yii::t('UserModule.user', 'It is not possible to save avatar!'));
        }

        $this->avatar = $filename;
    }

    public function isActive()
    {
        return (int)$this->status === self::STATUS_ACTIVE;
    }
}
<?php

/**
 * This is the model class for table "{{user_tokens}}".
 *
 * The followings are the available columns in table '{{user_tokens}}':
 * @property integer $id
 * @property integer $user_id
 * @property string $token
 * @property integer $type
 * @property integer $status
 * @property string $created
 * @property string $updated
 * @property string $ip
 */
class UserToken extends YModel
{
    /**
     * Типы токенов:
     * 
     * activate        - активация аккаунта
     * change_password - запрос на смену/восстановление пароля
     * email_verify    - подтверждение почты
     */
    const TYPE_ACTIVATE        = 1;
    const TYPE_CHANGE_PASSWORD = 2;
    const TYPE_EMAIL_VERIFY    = 3;

    /**
     * Статусы токенов:
     *
     * null     - по умолчанию
     * activate - использован
     * fail     - истёк/компроментирован
     */
    const STATUS_NULL     = null;
    const STATUS_ACTIVATE = 1;
    const STATUS_FAIL     = 2;

    /**
     * Старый статус
     * 
     * @var integer
     */
    protected $oldStatus = null;

    /**
     * Необходима ли перегенерация токена:
     * 
     * @var boolean
     */
    public $new_token = false;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{user_tokens}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, type, ip, token', 'required'),
            array('user_id, type, status', 'numerical', 'integerOnly'=>true),
            array('token, ip', 'length', 'max' => 255),
            array('updated, new_token', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, user_id, token, type, status, created, updated, ip', 'safe', 'on'=>'search'),
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
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'      => 'ID',
            'user_id' => Yii::t('UserModule.user', 'User'),
            'token'   => Yii::t('UserModule.user', 'Token'),
            'type'    => Yii::t('UserModule.user', 'Type'),
            'status'  => Yii::t('UserModule.user', 'Status'),
            'created' => Yii::t('UserModule.user', 'Created'),
            'updated' => Yii::t('UserModule.user', 'Updated'),
            'ip'      => Yii::t('UserModule.user', 'Ip'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->with = array('user');

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.token', $this->token, true);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('t.status', $this->status);

        // Критерия для поля "Дата создания":
        if (!empty($this->created) && strlen($this->created) == 10) {
            $criteria->addBetweenCondition('t.created', $this->created . ' 00:00:00', $this->created . ' 23:59:59');
        } else {
            $criteria->compare('t.created', $this->created, true);
        }

        // Критерия для поля "Дата изменения":
        if (!empty($this->updated) && strlen($this->updated) == 10) {
            $criteria->addBetweenCondition('t.updated', $this->updated . ' 00:00:00', $this->updated . ' 23:59:59');
        } else {
            $criteria->compare('t.updated', $this->updated, true);
        }

        $criteria->compare('t.ip', $this->ip, true);

        return new CActiveDataProvider(
            $this, array(
                'criteria'=>$criteria,
            )
        );
    }

    /**
     * Генерация токена для отправки пользователю:
     * завязывая для поиска на почту + токен
     * 
     * @return string
     */
    public function genActivateCode()
    {
        return md5($this->user->email . $this->token);
    }

    /**
     * Получаем список пользователей:
     * 
     * @return array User List
     */
    public static function getUserList()
    {
        return CHtml::listData(
            User::model()->findAll(), 'id', function($data) {
                return $data->getFullName();
            }
        );
    }

    /**
     * Список статусов:
     * 
     * @return array status list
     */
    public static function getStatusList()
    {
        return array(
            self::STATUS_NULL     => Yii::t('UserModule.user', 'Default'),
            self::STATUS_ACTIVATE => Yii::t('UserModule.user', 'Activated'),
            self::STATUS_FAIL     => Yii::t('UserModule.user', 'Compromised by'),
        );
    }

    /**
     * Список типов:
     * 
     * @return array type list
     */
    public static function getTypeList()
    {
        return array(
            self::TYPE_ACTIVATE        => Yii::t('UserModule.user', 'User activate'),
            self::TYPE_CHANGE_PASSWORD => Yii::t('UserModule.user', 'Change/reset password'),
            self::TYPE_EMAIL_VERIFY    => Yii::t('UserModule.user', 'Email verification'),
        );
    }

    /**
     * Получаем список дат:
     * 
     * @param  string $dateField - для какого поля
     * 
     * @return array
     */
    public static function getDateList($dateField = 'created')
    {
        $sql = Yii::app()->getDb()->getSchema() instanceof CMysqlSchema
                ? 'left(' . $dateField . ', 10)'
                : 'to_char(' . $dateField . ', \'YYYY-MM-DD\')';

        // Список дат, обрезаем до формата YYYY-MM-DD и кешируем запрос:
        $dateList = self::model()->cache(
            3600, new TagsCache('user-tokens-dateList', 'dateList-' . $dateField)
        )->findAll(
            array(
                'select' => $sql . ' as ' . $dateField,
                'group' => $dateField,
                'order' => $dateField . ' DESC'
            )
        );

        return CHtml::listData($dateList, $dateField, $dateField);
    }

    /**
     * Получаем строковое занчение типа:
     * 
     * @return mixed
     */
    public function getType()
    {
        $typeList = $this->getTypeList();

        return isset($typeList[$this->type])
                ? $typeList[$this->type]
                : $this->type;
    }

    /**
     * Получаем строковое занчение статуса:
     * 
     * @return mixed
     */
    public static function getStatus($status = null)
    {

        $statusList = self::getStatusList();

        return !empty($status) && isset($statusList[$status])
                ? $statusList[$status]
                : $status;
    }

    public function getIsCompromised()
    {
        return $this->status === self::STATUS_FAIL;
    }

    /**
     * Создание токена активации:
     * 
     * @param User    $user   - пользователь
     * @param integer $status - статус токена
     * 
     * @return mixed
     *
     * @throws Exception
     */
    public static function newActivate(User $user, $status = self::STATUS_NULL)
    {
        if (!empty($status) && self::getStatus($status) === null) {
            throw new Exception(
                Yii::t('UserModule.user', 'Unknown token status')
            );
        }

        return self::newToken($user, self::TYPE_ACTIVATE, $status);
    }

    /**
     * Создание токена изменения/сброса пароля:
     * 
     * @param User $user - пользователь
     * 
     * @return mixed
     *
     * @throws Exception
     */
    public static function newRecovery(User $user)
    {
        return self::newToken($user, self::TYPE_CHANGE_PASSWORD);
    }

    /**
     * Верификация почты:
     * 
     * @param User    $user   - пользователь
     * @param integer $status - статус токена
     * 
     * @return mixed
     *
     * @throws Exception
     */
    public static function newVerifyEmail(User $user, $status = self::STATUS_NULL)
    {
        if (!empty($status) && self::getStatus($status) === null) {
            throw new Exception(
                Yii::t('UserModule.user', 'Unknown token status')
            );
        }

        return self::newToken($user, self::TYPE_EMAIL_VERIFY, $status);
    }

    /**
     * Генерация нового токена:
     * 
     * @return string
     */
    protected static function generateToken()
    {
        return md5(uniqid(false, true));
    }

    /**
     * Создание токена по типу:
     * 
     * @param User $user   - пользователь
     * @param int  $type   - тип токена
     * @param int  $status - статус токена
     * 
     * @return mixed
     *
     * @throws Exception
     */
    protected static function newToken(User $user, $type = null, $status = self::STATUS_NULL)
    {
        $token          = new UserToken;
        $token->user_id = $user->id;
        $token->token   = self::generateToken();
        $token->type    = $type;
        $token->status  = $status;
        $token->ip      = Yii::app()->getRequest()->getUserHostAddress();

        if ($status !== self::STATUS_NULL) {
            $token->updated = new CDbExpression('NOW()');
        }

        try {
            if ($token->save()) {

                return true;

            } else {

                $errors = array();

                foreach ((array)$token->getErrors() as $value) {
                    $errors[] = implode("\n", $value);
                }

                throw new Exception(
                    implode("\n", $errors)
                );
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }
    }

    /**
     * Поиск токена по ключу и типу:
     * 
     * @param string  $token - ключ токена
     * @param integer $type  - тип токена
     * 
     * @return UserToken $model
     *
     * @throws Exception If empty($type)
     */
    public function getToken($token, $type = null)
    {
        if (empty($type)) {
            throw new Exception(
                Yii::t('UserModule.user', 'Unknown token type')
            );
        }

        $criteria = new CDbCriteria();
        
        $criteria->compare('token', $token);
        $criteria->compare('type', $type);

        // Токен не должен быть скомпроментированным:
        $criteria->addCondition('status != :status', array(':status' => self::STATUS_FAIL));

        return self::model()->find($criteria);
    }

    /**
     * Перед сохранением необходимо:
     * - если новая запись указать время создания
     * - если обновляется запись, то выставить время обновления
     * 
     * @return void
     */
    public function beforeSave()
    {
        if ($this->getIsNewRecord()) {
            $this->created = new CDbExpression('NOW()');
        } else {
            $this->updated = new CDbExpression('NOW()');
        }

        (int) $this->new_token === 0 || ($this->token = $this->generateToken());

        Yii::app()->cache->clear('user-tokens-dateList');

        return parent::beforeSave();
    }

    /**
     * Получаем полное имя пользователя:
     * 
     * @return mixed
     */
    public function getFullName()
    {
        return $this->user instanceof User
                ? $this->user->getFullName()
                : $this->user_id;
    }

    /**
     * Форматирование даты:
     * 
     * @param string $dateField - дата
     * @param string $format    - формат
     * 
     * @return string
     */
    public static function beautifyDate($dateField, $format = 'yyyy-MM-dd HH:mm')
    {
        return Yii::app()->dateFormatter->format($format, $dateField);
    }

    /**
     * Метод компрометации токена:
     * 
     * @return boolean
     */
    public function compromise()
    {
        $this->status = self::STATUS_FAIL;

        return $this->save(array('status'));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserToken the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
}

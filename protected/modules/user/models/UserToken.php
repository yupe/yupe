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
 * @property string $create_time
 * @property string $update_time
 * @property string $ip
 * @property string $expire_time
 */
class UserToken extends yupe\models\YModel
{
    /**
     * Типы токенов:
     *
     * activate        - активация аккаунта
     * change_password - запрос на смену/восстановление пароля
     * email_verify    - подтверждение почты
     * cookie_auth     - авторизация через куки
     */
    const TYPE_ACTIVATE = 1;
    const TYPE_CHANGE_PASSWORD = 2;
    const TYPE_EMAIL_VERIFY = 3;
    const TYPE_COOKIE_AUTH = 4;

    /**
     * Статусы токенов:
     *
     * null     - по умолчанию
     * activate - использован
     * fail     - истёк/компроментирован
     */
    const STATUS_NEW = 0;
    const STATUS_ACTIVATE = 1;
    const STATUS_FAIL = 2;

    /**
     * Старый статус
     *
     * @var integer
     */
    protected $oldStatus = null;

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
        return [
            ['user_id, type, ip, token, expire_time', 'required'],
            ['user_id, type, status', 'numerical', 'integerOnly' => true],
            ['token, ip', 'length', 'max' => 255],
            ['update_time', 'safe'],
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            ['id, user_id, token, type, status, create_time, update_time, ip', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'user' => [self::BELONGS_TO, 'User', 'user_id'],
        ];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'user_id' => Yii::t('UserModule.user', 'User'),
            'token'   => Yii::t('UserModule.user', 'Token'),
            'type'    => Yii::t('UserModule.user', 'Type'),
            'status'  => Yii::t('UserModule.user', 'Status'),
            'create_time' => Yii::t('UserModule.user', 'Created'),
            'update_time' => Yii::t('UserModule.user', 'Updated'),
            'ip'      => Yii::t('UserModule.user', 'Ip'),
            'expire_time'  => Yii::t('UserModule.user', 'Expire')
        ];
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
     *                             based on the search/filter conditions.
     */
    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria();

        $criteria->with = ['user'];

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.user_id', $this->user_id);
        $criteria->compare('t.token', $this->token, true);
        $criteria->compare('t.type', $this->type);
        $criteria->compare('t.status', $this->status);

        // Критерия для поля "Дата создания":
        if (!empty($this->create_time) && strlen($this->create_time) == 10) {
            $criteria->addBetweenCondition('t.create_time', $this->create_time . ' 00:00:00', $this->create_time . ' 23:59:59');
        } else {
            $criteria->compare('t.create_time', $this->create_time, true);
        }

        // Критерия для поля "Дата изменения":
        if (!empty($this->update_time) && strlen($this->update_time) == 10) {
            $criteria->addBetweenCondition('t.update_time', $this->update_time . ' 00:00:00', $this->update_time . ' 23:59:59');
        } else {
            $criteria->compare('t.update_time', $this->update_time, true);
        }

        $criteria->compare('t.ip', $this->ip, true);
        $criteria->compare('t.expire_time', $this->expire_time, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort'     => [
                    'defaultOrder' => 't.id DESC',
                ]
            ]
        );
    }

    /**
     * Получаем список пользователей:
     *
     * @return array User List
     */
    public static function getUserList()
    {
        return CHtml::listData(
            User::model()->findAll(),
            'id',
            function ($data) {
                return $data->getFullName();
            }
        );
    }

    /**
     * Список статусов:
     *
     * @return array status list
     */
    public function getStatusList()
    {
        return [
            self::STATUS_NEW      => Yii::t('UserModule.user', 'New'),
            self::STATUS_ACTIVATE => Yii::t('UserModule.user', 'Activated'),
            self::STATUS_FAIL     => Yii::t('UserModule.user', 'Compromised by'),
        ];
    }

    /**
     * Список типов:
     *
     * @return array type list
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_ACTIVATE        => Yii::t('UserModule.user', 'User activate'),
            self::TYPE_CHANGE_PASSWORD => Yii::t('UserModule.user', 'Change/reset password'),
            self::TYPE_EMAIL_VERIFY    => Yii::t('UserModule.user', 'Email verification'),
            self::TYPE_COOKIE_AUTH     => Yii::t('UserModule.user', 'Cookie auth'),
        ];
    }

    /**
     * Получаем список дат:
     *
     * @param string $dateField - для какого поля
     *
     * @return array
     */
    public static function getDateList($dateField = 'create_time')
    {
        $sql = 'left(' . $dateField . ', 10)';

        // Список дат, обрезаем до формата YYYY-MM-DD и кешируем запрос:
        $dateList = self::model()->cache(
            3600,
            new TagsCache('user-tokens-dateList', 'dateList-' . $dateField)
        )->findAll(
                [
                    'select' => $sql . ' as ' . $dateField,
                    'group'  => $dateField,
                    'order'  => $dateField . ' DESC'
                ]
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
    public function getStatus()
    {
        $statusList = $this->getStatusList();

        $status = (int)$this->status;

        return isset($statusList[$status]) ? $statusList[$status] : $status;
    }

    public function getIsCompromised()
    {
        return (int)$this->status === self::STATUS_FAIL;
    }

    public function beforeValidate()
    {
        if (!$this->ip) {
            $this->ip = Yii::app()->getRequest()->userHostAddress;
        }

        return parent::beforeValidate();
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
            $this->create_time = new CDbExpression('NOW()');
        }

        $this->update_time = new CDbExpression('NOW()');

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
     * @param string $format - формат
     *
     * @return string
     */
    public static function beautifyDate($dateField, $format = 'yyyy-MM-dd HH:mm')
    {
        return Yii::app()->getDateFormatter()->format($format, $dateField);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param  string $className active record class name.
     * @return UserToken the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function compromise()
    {
        $this->status = self::STATUS_FAIL;

        return $this->save();
    }
}

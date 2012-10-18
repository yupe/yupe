<?php

/**
 * This is the model class for table "{{FeedBack}}".
 *
 * The followings are the available columns in table '{{FeedBack}}':
 * @property integer $id
 * @property string $creation_date
 * @property string $change_date
 * @property string $name
 * @property string $email
 * @property string $theme
 * @property string $text
 * @property integer $type
 * @property integer $status
 * @property integer $ip
 * @property string  $phone
 */
class FeedBack extends YModel
{

    const STATUS_NEW           = 0;
    const STATUS_PROCESS       = 1;
    const STATUS_FINISHED      = 2;
    const STATUS_ANSWER_SENDED = 3;

    const TYPE_DEFAULT = 0;
    
    const IS_FAQ_NO = 0;
    const IS_FAQ    = 1;

    /**
     * Returns the static model of the specified AR class.
     * @return FeedBack the static model class
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
        return '{{feedback}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, email, theme, text', 'required'),
            array('name, email, theme, text, phone', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('type, status, answer_user, is_faq, type', 'numerical', 'integerOnly' => true),
            array('is_faq', 'in', 'range' => array(0, 1)),
            array('status', 'in', 'range' => array_keys($this->statusList)),
            array('type', 'in', 'range' => array_keys($this->typeList)),
            array('name, email, answer_date', 'length', 'max' => 100),
            array('theme', 'length', 'max' => 150),
            array('phone', 'length', 'max' => 100),
            array('email', 'email'),
            array('answer', 'filter', 'filter' => 'trim'),
            array('id, creation_date, change_date, name, email, theme, text, type, status, ip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('feedback', 'Идентификатор'),
            'creation_date' => Yii::t('feedback', 'Дата создания'),
            'change_date'   => Yii::t('feedback', 'Дата изменения'),
            'name'          => Yii::t('feedback', 'Имя'),
            'email'         => Yii::t('feedback', 'Email'),
            'phone'         => Yii::t('feedback', 'Телефон'),
            'theme'         => Yii::t('feedback', 'Тема'),
            'text'          => Yii::t('feedback', 'Текст'),
            'type'          => Yii::t('feedback', 'Тип'),
            'answer'        => Yii::t('feedback', 'Ответ'),
            'answer_date'   => Yii::t('feedback', 'Дата ответа'),
            'answer_user'   => Yii::t('feedback', 'Ответил'),
            'is_faq'        => Yii::t('feedback', 'В разделе FAQ'),
            'status'        => Yii::t('feedback', 'Статус'),
            'ip'            => Yii::t('feedback', 'Ip-адрес'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('creation_date', $this->creation_date, true);
        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('theme', $this->theme, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip);
        $criteria->compare('is_faq', $this->is_faq);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort'     => array('defaultOrder' => 'status ASC, change_date ASC'),
        ));
    }

    public function beforeValidate()
    {
        $this->change_date = new CDbExpression('NOW()');

        if ($this->isNewRecord)
        {
            $this->creation_date = $this->change_date;
            $this->ip = Yii::app()->request->userHostAddress;

            if (!$this->type)
                $this->type = self::TYPE_DEFAULT;
        }

        return parent::beforeSave();
    }

    public function scopes()
    {
        return array(
            'new'      => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_NEW),
             ),
            'answered' => array(
                'condition' => 'status = :status',
                'params'    => array(':status' => self::STATUS_ANSWER_SENDED),
            ),
            'faq'      => array(
                'condition' => 'is_faq = :is_faq',
                'params'    => array(':is_faq' => self::IS_FAQ),
            ),
        );
    }

    public function getAnsweredUser()
    {
        return $this->answer_user ? User::model()->findByPk($this->answer_user)->getFullName() : Yii::t('feedback', '—');
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW           => Yii::t('feedback', 'Новое сообщение'),
            self::STATUS_PROCESS       => Yii::t('feedback', 'Сообщение в обработке'),
            self::STATUS_FINISHED      => Yii::t('feedback', 'Сообщение обработано'),
            self::STATUS_ANSWER_SENDED => Yii::t('feedback', 'Ответ отправлен'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('feedback', 'Статус сообщения неизвестен');
    }

    public function getTypeList()
    {
        $types = Yii::app()->getModule('feedback')->types;

        if ($types)
            $types[self::TYPE_DEFAULT] = Yii::t('feedback', 'По умолчанию');
        else
            $types = array(self::TYPE_DEFAULT => Yii::t('feedback', 'По умолчанию'));

        return $types;
    }

    public function getType()
    {
        $data = $this->typeList;
        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('feedback', 'Неизвестный тип сообщения!');
    }

    public function getIsFaqList()
    {
        return array(
            self::IS_FAQ_NO => Yii::t('feedback', 'Нет'),
            self::IS_FAQ    => Yii::t('feedback', 'Да'),
        );
    }

    public function getIsFaq()
    {
        $data = $this->isFaqList;
        return isset($data[$this->is_faq]) ? $data[$this->is_faq] : Yii::t('feedback', '*неизвестно*');
    }
}

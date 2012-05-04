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
 */
class FeedBack extends CActiveRecord
{

    const STATUS_NEW = 0;
    const STATUS_PROCESS = 1;
    const STATUS_FINISHED = 2;
    const STATUS_ANSWER_SENDED = 3;

    const TYPE_DEFAULT = 0;

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW => Yii::t('feedback', 'Новое сообщение'),
            self::STATUS_PROCESS => Yii::t('feedback', 'Сообщение в обработке'),
            self::STATUS_FINISHED => Yii::t('feedback', 'Сообщение обработано'),
            self::STATUS_ANSWER_SENDED => Yii::t('feedback', 'Ответ отправлен'),
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();
        return array_key_exists($this->status, $data)
            ? $data[$this->status]
            : Yii::t('feedback', 'Статус сообщения неизвестен');
    }

    public function getTypeList()
    {
        return is_array(Yii::app()->getModule('feedback')->types)
            ? Yii::app()->getModule('feedback')->types
            : array();
    }

    public function getType()
    {
        $data = $this->getTypeList();
        return array_key_exists($this->type, $data)
            ? $data[$this->type]
            : Yii::t('feedback', 'Неизвестный тип сообщения!');
    }

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
            //@formatter:off
            array('name, email, theme, text', 'required'),
            array('type, status, answer_user, is_faq', 'numerical', 'integerOnly' => true),
            array('is_faq', 'in', 'range' => array(0, 1)),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('name, email', 'length', 'max' => 100),
            array('theme', 'length', 'max' => 150),
            array('email', 'email'),
            array('answer', 'filter', 'filter' => 'trim'),
            array('id, creation_date, change_date, name, email, theme, text, type, status, ip', 'safe', 'on' => 'search'),
            //@formatter:on
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('feedback', 'Идентификатор'),
            'creation_date' => Yii::t('feedback', 'Дата создания'),
            'change_date' => Yii::t('feedback', 'Дата изменения'),
            'name' => Yii::t('feedback', 'Имя'),
            'email' => Yii::t('feedback', 'Email'),
            'theme' => Yii::t('feedback', 'Тема'),
            'text' => Yii::t('feedback', 'Текст'),
            'type' => Yii::t('feedback', 'Тип'),
            'answer' => Yii::t('feedback', 'Ответ'),
            'answer_date' => Yii::t('feedback', 'Дата ответа'),
            'answer_user' => Yii::t('feedback', 'Ответил'),
            'is_faq' => Yii::t('feedback', 'В разделе FAQ'),
            'status' => Yii::t('feedback', 'Статус'),
            'ip' => Yii::t('feedback', 'Ip-адрес'),
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

        return new CActiveDataProvider('FeedBack', array('criteria' => $criteria));
    }

    public function beforeValidate()
    {
        $this->change_date = new CDbExpression('NOW()');

        if ($this->isNewRecord)
        {
            $this->creation_date = $this->change_date;
            $this->ip = Yii::app()->request->userHostAddress;
        }

        return parent::beforeSave();
    }

    public function scopes()
    {
        return array('new' => array(
            'condition' => 'status = :status',
            'params' => array(':status' => self::STATUS_NEW),
        ));
    }

    public function getIsFaq()
    {
        return $this->is_faq ? Yii::t('feedback', 'Да') : Yii::t('feedback', 'Нет');
    }

}

<?php

/**
 * This is the model class for table "mail_template".
 *
 * The followings are the available columns in table 'mail_template':
 * @property string $id
 * @property string $event_id
 * @property string $name
 * @property string $description
 * @property string $from
 * @property string $to
 * @property string $theme
 * @property string $body
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property MailEvent $event
 */
class MailTemplate extends CActiveRecord
{
    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 0;

    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE     => Yii::t('mail', 'активен'),
            self::STATUS_NOT_ACTIVE => Yii::t('mail', 'не активен')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('mail', '--неизвестно--');
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MailTemplate the static model class
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
        return '{{mail_template}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, name, from, to, theme', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('event_id, code, name, from, to, theme, body', 'required'),
            array('status', 'numerical', 'integerOnly' => true),
            array('event_id', 'length', 'max' => 10),
            array('name, from, to', 'length', 'max' => 300),
            array('code', 'length', 'max' => 100),
            array('code', 'unique'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, event_id, name, description, from, to, theme, body, status', 'safe', 'on' => 'search'),
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
            'event' => array(self::BELONGS_TO, 'MailEvent', 'event_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('mail', 'ID'),
            'event_id'    => Yii::t('mail', 'Событие'),
            'name'        => Yii::t('mail', 'Название'),
            'description' => Yii::t('mail', 'Описание'),
            'from'        => Yii::t('mail', 'От'),
            'to'          => Yii::t('mail', 'Кому'),
            'theme'       => Yii::t('mail', 'Тема'),
            'body'        => Yii::t('mail', 'Сообщение'),
            'code'        => Yii::t('mail', 'Символьный код'),
            'status'      => Yii::t('mail', 'Статус'),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('event_id', $this->event_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('from', $this->from, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('theme', $this->theme, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array('criteria' => $criteria));
    }

}
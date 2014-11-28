<?php

/**
 * This is the model class for table "sms_messages".
 *
 * The followings are the available columns in table 'sms_messages':
 *
 * @property string $id
 * @property string $to
 * @property string $text
 * @property integer $status
 *
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */
class Sms extends yupe\models\YModel
{
    const STATUS_ERROR     = 2;
    const STATUS_RECEIVED  = 1;
    const STATUS_SENT      = 0;

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return MailTemplate the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Получаем имя таблицы:
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{sms_sms_messages}}';
    }

    /**
     * Получаем правила валидации полей таблицы:
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['to, text', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['to, text', 'required'],
            ['status', 'numerical', 'integerOnly' => true],
            ['to', 'length', 'max' => 25],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, to, text, status', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Получаем связи данной таблицы:
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'to' => [self::BELONGS_TO, 'User', 'phone'],
        ];
    }

    /**
     * Получаем атрибуты меток полей данной таблицы:
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('SmsModule.sms', 'ID'),
            'to'          => Yii::t('SmsModule.sms', 'For'),
            'text'        => Yii::t('SmsModule.sms', 'Message'),
            'status'      => Yii::t('SmsModule.sms', 'Status'),
        ];
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }

    /**
     * Получаем массив статусов:
     *
     * @return miced status
     **/
    public function getStatusList()
    {
        return [
            self::STATUS_SENT     => Yii::t('SmsModule.sms', 'sent'),
            self::STATUS_RECEIVED => Yii::t('SmsModule.sms', 'received'),
            self::STATUS_ERROR => Yii::t('SmsModule.sms', 'error'),
        ];
    }

    /**
     * Получаем статусов записи:
     *
     * @return string status
     **/
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('SmsModule.sms', '--unknown--');
    }
}

<?php
/**
 * MailTemplate model class
 * Класс модели MailTemplate
 *
 * @category YupeModel
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/

/**
 * This is the model class for table "mail_template".
 *
 * The followings are the available columns in table 'mail_template':
 *
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
 *
  * MailTemplate model class
 * Класс модели MailTemplate
 *
 * @category YupeModel
 * @package  YupeCMS
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class MailTemplate extends YModel
{
    const STATUS_ACTIVE     = 1;
    const STATUS_NOT_ACTIVE = 0;

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
        return '{{mail_template}}';
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
     * Получаем связи данной таблицы:
     *
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
     * Получаем атрибуты меток полей данной таблицы:
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'          => Yii::t('MailModule.mail', 'ID'),
            'event_id'    => Yii::t('MailModule.mail', 'Событие'),
            'name'        => Yii::t('MailModule.mail', 'Название'),
            'description' => Yii::t('MailModule.mail', 'Описание'),
            'from'        => Yii::t('MailModule.mail', 'От'),
            'to'          => Yii::t('MailModule.mail', 'Кому'),
            'theme'       => Yii::t('MailModule.mail', 'Тема'),
            'body'        => Yii::t('MailModule.mail', 'Сообщение'),
            'code'        => Yii::t('MailModule.mail', 'Символьный код'),
            'status'      => Yii::t('MailModule.mail', 'Статус'),
        );
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
        $criteria->compare('event_id', $this->event_id, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('from', $this->from, true);
        $criteria->compare('to', $this->to, true);
        $criteria->compare('theme', $this->theme, true);
        $criteria->compare('body', $this->body, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

    /**
     * Получаем массив статусов:
     *
     * @return miced status
     **/
    public function getStatusList()
    {
        return array(
            self::STATUS_ACTIVE     => Yii::t('MailModule.mail', 'активен'),
            self::STATUS_NOT_ACTIVE => Yii::t('MailModule.mail', 'не активен'),
        );
    }

    /**
     * Получаем статусов записи:
     *
     * @return string status
     **/
    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('MailModule.mail', '--неизвестно--');
    }
}
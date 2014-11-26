<?php

/**
 * This is the model class for table "mail_event".
 *
 * The followings are the available columns in table 'mail_event':
 *
 * @property string $id
 * @property string $code
 * @property string $name
 * @property string $description
 *
 * The followings are the available model relations:
 * @property MailTemplate[] $mailTemplates
 *
 * MailEvent model class
 * Класс модели MailEvent
 *
 * @category YupeModel
 * @package  yupe.modules.models
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     http://yupe.ru
 **/
class MailEvent extends yupe\models\YModel
{
    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return MailEvent the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * Получаем название таблицы:
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{mail_mail_event}}';
    }

    /**
     * Получаем правила валидации:
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return [
            ['name, code, description', 'filter', 'filter' => [$obj = new CHtmlPurifier(), 'purify']],
            ['code, name', 'required'],
            ['code', 'length', 'max' => 100],
            ['name', 'length', 'max' => 300],
            ['description', 'safe'],
            ['code', 'unique'],
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            ['id, code, name, description', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * Получаем свзи данной таблицы:
     *
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return [
            'templates' => [self::HAS_MANY, 'MailTemplate', 'event_id'],
        ];
    }

    /**
     * Получаем атрибуты меток полей таблицы:
     *
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'          => Yii::t('MailModule.mail', 'ID'),
            'code'        => Yii::t('MailModule.mail', 'Symbolic code'),
            'name'        => Yii::t('MailModule.mail', 'Title'),
            'description' => Yii::t('MailModule.mail', 'Description'),
        ];
    }

    /**
     * Получение короткого описания:
     *
     * @return string short decription
     **/
    public function getShortDescription()
    {
        if (strlen($this->description) <= 100) {
            return $this->description;
        } else {
            return substr($this->description, 0, 100) . " ...";
        }
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

        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id, true);
        $criteria->compare('code', $this->code, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('description', $this->description, true);

        return new CActiveDataProvider(get_class($this), ['criteria' => $criteria]);
    }
}

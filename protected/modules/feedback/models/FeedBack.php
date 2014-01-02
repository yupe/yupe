<?php
/**
 * FeedBack основная модель
 *
 * @category YupeController
 * @package  yupe.modules.feedback.models
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/

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
 * @property integer $category_id
 * @property string  $phone
 */
class FeedBack extends yupe\models\YModel
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
     * @param string $className
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
        return '{{feedback_feedback}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, email, theme, text', 'required'),
            array('name, email, theme, text, phone', 'filter', 'filter' => array($obj = new CHtmlPurifier(), 'purify')),
            array('type, status, answer_user, is_faq, type, category_id', 'numerical', 'integerOnly' => true),
            array('is_faq', 'in', 'range' => array_keys($this->getIsFaqList())),
            array('status', 'in', 'range' => array_keys($this->getStatusList())),
            array('type', 'in', 'range' => array_keys($this->getTypeList())),
            array('name, email, phone', 'length', 'max' => 150),
            array('theme', 'length', 'max' => 250),
            array('ip', 'length', 'max' => 20),
            array('answer_date', 'length', 'max' => 100),
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
            'id'            => Yii::t('FeedbackModule.feedback', 'Identifier'),
            'creation_date' => Yii::t('FeedbackModule.feedback', 'Created'),
            'change_date'   => Yii::t('FeedbackModule.feedback', 'Updated'),
            'name'          => Yii::t('FeedbackModule.feedback', 'Name'),
            'email'         => Yii::t('FeedbackModule.feedback', 'Email'),
            'phone'         => Yii::t('FeedbackModule.feedback', 'Phone'),
            'theme'         => Yii::t('FeedbackModule.feedback', 'Topic'),
            'text'          => Yii::t('FeedbackModule.feedback', 'Text'),
            'type'          => Yii::t('FeedbackModule.feedback', 'Type'),
            'answer'        => Yii::t('FeedbackModule.feedback', 'Reply'),
            'answer_date'   => Yii::t('FeedbackModule.feedback', 'Reply time'),
            'answer_user'   => Yii::t('FeedbackModule.feedback', 'Replied'),
            'is_faq'        => Yii::t('FeedbackModule.feedback', 'In FAQ'),
            'status'        => Yii::t('FeedbackModule.feedback', 'Status'),
            'ip'            => Yii::t('FeedbackModule.feedback', 'Ip-address'),
            'category_id'   => Yii::t('FeedbackModule.feedback', 'Category'),
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

        if (!empty($this->creation_date)) {
            $criteria->addBetweenCondition(
                'creation_date',
                $this->creation_date . ' 00:00:00',
                $this->creation_date . ' 23:59:59',
                'AND'
            );
        }

        $criteria->compare('change_date', $this->change_date, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('theme', $this->theme, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('type', $this->type);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip);
        $criteria->compare('is_faq', $this->is_faq);
        $criteria->compare('category_id', $this->category_id);

        return new CActiveDataProvider(get_class($this), array(
            'criteria' => $criteria,
            'sort'     => array('defaultOrder' => 'creation_date DESC, status ASC'),
        ));
    }

    /**
     * Обновляем дату изменения. Если новая запись
     * обновляем необходимые поля:
     * 
     * @return void
     */
    public function beforeValidate()
    {
        $this->change_date = new CDbExpression('NOW()');

        if ($this->isNewRecord)
        {
            $this->creation_date = $this->change_date;
            $this->ip            = Yii::app()->getRequest()->userHostAddress;

            if (!$this->type) {
                $this->type = self::TYPE_DEFAULT;
            }
        }

        return parent::beforeValidate();
    }

    /**
     * Именованные условия:
     * 
     * @return array
     */
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

    /**
     * Имя пользователя который ответил:
     * 
     * @return string
     */
    public function getAnsweredUser()
    {
        return $this->answer_user ? User::model()->findByPk($this->answer_user) : Yii::t('FeedbackModule.feedback', '-');
    }

    /**
     * Список возможных статусов:
     * 
     * @return array
     */
    public function getStatusList()
    {
        return array(
            self::STATUS_NEW           => Yii::t('FeedbackModule.feedback', 'New message'),
            self::STATUS_PROCESS       => Yii::t('FeedbackModule.feedback', 'Message in handle'),
            self::STATUS_FINISHED      => Yii::t('FeedbackModule.feedback', 'Message was handled'),
            self::STATUS_ANSWER_SENDED => Yii::t('FeedbackModule.feedback', 'Reply was received'),
        );
    }

    /**
     * Получаем текстовый статус:
     * 
     * @return string
     */
    public function getStatus()
    {
        $data = $this->getStatusList();
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('FeedbackModule.feedback', 'Unknown status message');
    }

    /**
     * Список возможных типов:
     * 
     * @return array
     */
    public function getTypeList()
    {
        $types = Yii::app()->getModule('feedback')->types;

        if ($types) {
            $types[self::TYPE_DEFAULT] = Yii::t('FeedbackModule.feedback', 'Default');
        }
        else{
            $types = array(self::TYPE_DEFAULT => Yii::t('FeedbackModule.feedback', 'Default'));
        }

        return $types;
    }

    /**
     * Получаем тип:
     * 
     * @return string
     */
    public function getType()
    {
        $data = $this->getTypeList();
        return isset($data[$this->type]) ? $data[$this->type] : Yii::t('FeedbackModule.feedback', 'Unknown message type');
    }

    /**
     * Массив текстовых статусов:
     * 
     * @return array
     */
    public function getIsFaqList()
    {
        return array(
            self::IS_FAQ_NO => Yii::t('FeedbackModule.feedback', 'No'),
            self::IS_FAQ    => Yii::t('FeedbackModule.feedback', 'Yes'),
        );
    }

    /**
     * Получаем класс по статусу:
     * 
     * @return string label-class
     */
    public function getStatusClass()
    {
        return $this->status
                ? (
                    ($this->status == 1)
                    ? 'warning'
                    : (
                        ($this->status==3)
                        ?  'success'
                        : 'default'
                    )
                )
                : 'info';
    }

    /**
     * Получаем текст, при необходимости обрезаем:
     * 
     * @param mixed $size - максимальная длина
     * 
     * @return string
     */
    public function getText($size = false)
    {
        if (false === $size || $size > mb_strlen($this->text)){
            return $this->text;
        }
        
        $p = new CHtmlPurifier();
        return $p->purify(
            mb_substr($this->text, 0, $size) . '...'
        );
    }

    /**
     * Находится ли ответ в FAQ:
     * 
     * @return string
     */
    public function getIsFaq()
    {
        $data = $this->getIsFaqList();
        return isset($data[$this->is_faq]) ? $data[$this->is_faq] : Yii::t('FeedbackModule.feedback', '*unknown*');
    }

    /**
     * Связи:
     * 
     * @return array
     */
    public function relations()
    {
        return array(
            'category' => array(self::BELONGS_TO,'Category','category_id'),
        );
    }

    /**
     * Категория:
     * 
     * @return string
     */
    public function getCategory()
    {
        return empty($this->category) ? '---' : $this->category->name;
    }
}

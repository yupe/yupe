<?php

/**
 * This is the model class for table "Comment".
 *
 * The followings are the available columns in table 'Comment':
 * @property string $id
 * @property string $model
 * @property string $modelId
 * @property string $creationDate
 * @property string $name
 * @property string $email
 * @property string $url
 * @property string $text
 * @property integer $status
 * @property string $ip
 * @property string $userId
 */
class Comment extends CActiveRecord
{

    const STATUS_NEED_CHECK = 0;
    const STATUS_APPROVED = 1;
    const STATUS_SPAM = 2;
    const STATUS_DELETED = 3;

    public $verifyCode;


    /**
     * Returns the static model of the specified AR class.
     * @return Comment the static model class
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
        return '{{Comment}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {        
        return array(
            array('model,modelId, name, email, text', 'required'),
            array('status, userId', 'numerical', 'integerOnly' => true),
            array('name, email, url', 'length', 'max' => 150),
            array('model', 'length', 'max' => 50),
            array('ip', 'length', 'max' => 20),
            array('email', 'email'),
            array('url', 'url'),
            array('name, email, text, url', 'filter', 'filter' => 'strip_tags'),
            array('verifyCode', 'YRequiredValidator', 'allowEmpty' => Yii::app()->user->isAuthenticated()),
            array('verifyCode', 'captcha', 'allowEmpty' => Yii::app()->user->isAuthenticated()),            
            array('id, model, modelId, creationDate, name, email, url, text, status, ip', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => Yii::t('comment', 'id'),
            'model' => Yii::t('comment', 'Тип модели'),
            'modelId' => Yii::t('comment', 'Модель'),
            'creationDate' => Yii::t('comment', 'Дата создания'),
            'name' => Yii::t('comment', 'Имя'),
            'email' => Yii::t('comment', 'Email'),
            'url' => Yii::t('comment', 'Сайт'),
            'text' => Yii::t('comment', 'Комментарий'),
            'status' => Yii::t('comment', 'Статус'),
            'verifyCode' => Yii::t('comment', 'Код проверки'),
            'ip' => Yii::t('comment', 'ip'),
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
        $criteria->compare('model', $this->model, true);
        $criteria->compare('modelId', $this->modelId, true);
        $criteria->compare('creationDate', $this->creationDate, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('text', $this->text, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('ip', $this->ip, true);

        return new CActiveDataProvider(get_class($this), array(
                                                              'criteria' => $criteria,
                                                         ));
    }

    public function beforeSave()
    {
        if (parent::beforeSave())
        {
            if ($this->isNewRecord)
            {
                $this->creationDate = new CDbExpression('NOW()');

                $this->ip = Yii::app()->request->userHostAddress;
            }

            return true;
        }

        return false;
    }

    public function scopes()
    {
        return array(
            'new' => array(
                'condition' => 'status = :status',
                'params' => array(':status' => self::STATUS_NEED_CHECK)
            ),
            'approved' => array(
                'condition' => 'status = :status',
                'params' => array(':status' => self::STATUS_APPROVED),
                'order' => 'creationDate DESC'
            )
        );
    }


    public function getStatusList()
    {
        return array(
            self::STATUS_APPROVED => Yii::t('comment', 'Принят'),
            self::STATUS_DELETED => Yii::t('comment', 'Удален'),
            self::STATUS_NEED_CHECK => Yii::t('comment', 'На проверке'),
            self::STATUS_SPAM => Yii::t('comment', 'Спам')
        );
    }

    public function getStatus()
    {
        $list = $this->getStatusList();

        return array_key_exists($this->status, $list) ? $list[$this->status]
            : Yii::t('comment', 'Статус неизвестен');
    }
}
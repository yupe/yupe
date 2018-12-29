<?php

/**
 * Class Callback
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $time
 * @property string $comment
 * @property integer $status
 * @property string $create_time
 * @property string $url
 * @property integer $agree
 * @property integer $type
 *
 */
class Callback extends \yupe\models\YModel
{
    /**
     *
     */
    const STATUS_NEW = 0;
    /**
     *
     */
    const STATUS_PROCESSED = 1;


    const TYPE_CALLBACK = 0;


    /**
     * @return string
     */
    public function tableName()
    {
        return '{{callback}}';
    }

    /**
     * @param null|string $className
     * @return $this
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['name, phone, agree', 'required'],
            ['name, comment', 'filter', 'filter' => 'trim'],
            ['name', 'length', 'max' => 30],
            ['time', 'length', 'max' => 5],
            [
                'time',
                'match',
                'pattern' => '/^([0-1][0-9]|[2][0-3]):([0-5][0-9])$/',
                'message' => Yii::t('CallbackModule.callback', 'Incorrect time value'),
            ],
            [
                'phone',
                'match',
                'pattern' => Yii::app()->getModule('callback')->phonePattern,
                'message' => Yii::t('CallbackModule.callback', 'Incorrect phone value'),
            ],
            ['comment', 'length', 'max' => 255],
            ['status, type', 'numerical', 'integerOnly' => true],
            ['url', 'url'],
            ['id, name, phone, time, comment, status, create_time, url, agree', 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('CallbackModule.callback', 'Name'),
            'phone' => Yii::t('CallbackModule.callback', 'Phone'),
            'time' => Yii::t('CallbackModule.callback', 'Time'),
            'comment' => Yii::t('CallbackModule.callback', 'Comment'),
            'status' => Yii::t('CallbackModule.callback', 'Status'),
            'create_time' => Yii::t('CallbackModule.callback', 'Created At'),
            'url' => Yii::t('CallbackModule.callback', 'Url'),
            'agree' => Yii::t('CallbackModule.callback', 'I agree to the processing of data'),
            'type' => Yii::t('CallbackModule.callback', 'Callback type')
        ];
    }

    /**
     * @return array
     */
    public function scopes()
    {
        return [
            'new' => [
                'condition' => 'status = :status',
                'params' => [':status' => self::STATUS_NEW],
            ],
            'processed' => [
                'condition' => 'status = :status',
                'params' => [':status' => self::STATUS_PROCESSED],
            ],
        ];
    }

    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'CTimestampBehavior' => [
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'create_time',
                'updateAttribute' => null,
            ],
        ];
    }

    /**
     * @return CActiveDataProvider
     */
    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('name', $this->name, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('time', $this->time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('agree', $this->agree, true);
        $criteria->compare('type', $this->type);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 'id DESC'],
            ]
        );
    }

    /**
     * @return array
     */
    public function getStatusList()
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_PROCESSED => 'Обработан',
        ];
    }

    /**
     * @return array
     */
    public function getStatusLabelList()
    {
        return [
            self::STATUS_NEW => ['class' => 'label-danger'],
            self::STATUS_PROCESSED => ['class' => 'label-success'],
        ];
    }

    /**
     * @return array
     */
    public function getTypeList()
    {
        return [
            self::TYPE_CALLBACK => 'Обратный звонок',
        ];
    }


    public function getType()
    {
        $data = $this->getTypeList();

        return isset($data[$this->type]) ? $data[$this->type] : '---';
    }
}
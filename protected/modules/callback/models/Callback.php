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
 */
class Callback extends \yupe\models\YModel
{
    const STATUS_NEW = 0;
    const STATUS_PROCESSED = 1;

    public function tableName()
    {
        return '{{callback}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return [
            ['name, phone', 'required'],
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
            ['status', 'numerical', 'integerOnly' => true],
            ['id, name, phone, time, comment, status', 'safe', 'on' => 'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('CallbackModule.callback', 'Name'),
            'phone' => Yii::t('CallbackModule.callback', 'Phone'),
            'time' => Yii::t('CallbackModule.callback', 'Time'),
            'comment' => Yii::t('CallbackModule.callback', 'Comment'),
            'status' => Yii::t('CallbackModule.callback', 'Status'),
        ];
    }

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

    public function search()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->id);
        $criteria->compare('comment', $this->comment, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
                'sort' => ['defaultOrder' => 'id DESC'],
            ]
        );
    }

    public function getStatusList()
    {
        return [
            self::STATUS_NEW => 'Новый',
            self::STATUS_PROCESSED => 'Обработан',
        ];
    }

    public function getStatusLabelList()
    {
        return [
            self::STATUS_NEW => ['class' => 'label-danger'],
            self::STATUS_PROCESSED => ['class' => 'label-success'],
        ];
    }
}
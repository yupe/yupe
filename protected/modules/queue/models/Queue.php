<?php

/**
 * Queue модель для работы с табличкой очереди
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.queue.models
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 *
 */


/**
 * This is the model class for table "queue".
 *
 * The followings are the available columns in table 'queue':
 *
 * @property string $id
 * @property string $worker
 * @property string $create_time
 * @property string $task
 * @property string $start_time
 * @property string $complete_time
 * @property integer $status
 * @property string $notice
 */
class Queue extends yupe\models\YModel
{
    const STATUS_NEW      = 0;
    const STATUS_COMLETED = 1;
    const STATUS_PROGRESS = 2;
    const STATUS_ERROR    = 3;

    const PRIORITY_NORMAL = 1;
    const PRIORITY_LOW    = 0;
    const PRIORITY_HIGH   = 2;

    public function beforeSave()
    {
        if ($this->isNewRecord) {
            $this->create_time = new CDbExpression('NOW()');
        }
        return parent::beforeSave();
    }

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className active record class name.
     *
     * @return Queue the static model class
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
        return '{{queue_queue}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('worker, task', 'required'),
            array('status, worker, priority', 'numerical', 'integerOnly' => true),
            array('status', 'in', 'range'  => array_keys($this->statusList)),
            array('priority', 'in', 'range' => array_keys($this->priorityList)),
            array('notice', 'length', 'max' => 255),
            array('start_time, complete_time', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, worker, create_time, task, start_time, complete_time, status, notice', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t('QueueModule.queue', 'ID'),
            'worker'        => Yii::t('QueueModule.queue', 'Handler'),
            'create_time'   => Yii::t('QueueModule.queue', 'Created at'),
            'task'          => Yii::t('QueueModule.queue', 'Task.'),
            'start_time'    => Yii::t('QueueModule.queue', 'Start'),
            'complete_time' => Yii::t('QueueModule.queue', 'Completing'),
            'status'        => Yii::t('QueueModule.queue', 'Status'),
            'notice'        => Yii::t('QueueModule.queue', 'Notice'),
            'priority'      => Yii::t('QueueModule.queue', 'Priority'),
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
        $criteria->compare('worker', $this->worker, true);
        $criteria->compare('create_time', $this->create_time, true);
        $criteria->compare('task', $this->task, true);
        $criteria->compare('start_time', $this->start_time, true);
        $criteria->compare('complete_time', $this->complete_time, true);
        $criteria->compare('status', $this->status);
        $criteria->compare('notice', $this->notice, true);
        $criteria->compare('priority', $this->priority, true);

        return new CActiveDataProvider(get_class($this), array('criteria' => $criteria));
    }

        public function getPriorityList()
    {
        return array(
            self::PRIORITY_LOW    => Yii::t('QueueModule.queue', 'Low'),
            self::PRIORITY_NORMAL => Yii::t('QueueModule.queue', 'Normal'),
            self::PRIORITY_HIGH   => Yii::t('QueueModule.queue', 'High'),
        );
    }

    public function getPriority()
    {
        $data = $this->priorityList;
        return isset($data[$this->priority]) ? $data[$this->priority] : Yii::t('QueueModule.queue', '-unknown-');
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_NEW      => Yii::t('QueueModule.queue', 'New'),
            self::STATUS_COMLETED => Yii::t('QueueModule.queue', 'Completed'),
            self::STATUS_PROGRESS => Yii::t('QueueModule.queue', 'Working'),
            self::STATUS_ERROR    => Yii::t('QueueModule.queue', 'Error'),
        );
    }

    public function getStatus()
    {
        $data = $this->statusList;
        return isset($data[$this->status]) ? $data[$this->status] : Yii::t('QueueModule.queue', '-unknown-');
    }
}
<?php

/**
 * Class OrderStatus
 *
 * @property integer $id
 * @property string $name
 * @property boolean $is_system
 */
class OrderStatus extends yupe\models\YModel
{
    const STATUS_NEW = 1;
    const STATUS_ACCEPTED = 2;
    const STATUS_FINISHED = 3;
    const STATUS_DELETED = 4;

    public function tableName()
    {
        return '{{store_order_status}}';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['name', 'filter', 'filter' => 'trim'],
            ['is_system', 'boolean'],
            ['id, name', 'safe', 'on' => 'search'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => Yii::t('OrderModule.order', '#'),
            'name' => Yii::t('OrderModule.order', 'Name'),
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria();

        $criteria->compare('id', $this->id);
        $criteria->compare('name', $this->name, true);

        return new CActiveDataProvider(
            $this, [
                'criteria' => $criteria,
            ]
        );
    }

    public function beforeDelete()
    {
        if ($this->is_system) {
            $this->addError('statuses', Yii::t('OrderModule.order', 'You can not delete a system status.'));

            return false;
        }

        return parent::beforeDelete();
    }

    public function getList()
    {
        return CHtml::listData(self::model()->findAll(), 'id', 'name');
    }

    public function getTitle()
    {
        $data = $this->getList();

        return isset($data[$this->id]) ? $data[$this->id] : Yii::t('OrderModule.order', '*unknown*');
    }

    public function getLabels()
    {
        return [
            self::STATUS_FINISHED => ['class' => 'label-success'],
            self::STATUS_ACCEPTED => ['class' => 'label-info'],
            self::STATUS_NEW => ['class' => 'label-default'],
            self::STATUS_DELETED => ['class' => 'label-danger'],
        ];
    }
}
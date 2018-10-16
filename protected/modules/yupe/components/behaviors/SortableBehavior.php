<?php
namespace yupe\components\behaviors;

use CActiveRecordBehavior;
use Yii;

/**
 * Class SortableBehavior
 * @package yupe\components\behaviors
 */
class SortableBehavior extends CActiveRecordBehavior
{
    /**
     * @var string
     */
    public $attributeName = 'position';

    /**
     * @param \CModelEvent $event
     */
    public function beforeSave($event)
    {
        if ($this->getOwner()->getIsNewRecord()) {
            $position = Yii::app()->getDb()->createCommand("select max({$this->attributeName}) from {$this->getOwner()->tableName()}")->queryScalar();
            $this->getOwner()->{$this->attributeName} = (int)$position + 1;
        }

        return parent::beforeSave($event);
    }
} 

<?php

use yupe\widgets\YWidget;

/**
 * Show products viewed by user
 */
class ViewedWidget extends YWidget
{
    /**
     * @var string Widget view file
     */
    public $view = 'default';

    /**
     * @var int|null The number of displayed products. Default: all
     */
    public $limit = null;

    /**
     * @var string|null Sorting of displayed products. Default: by view time desc
     */
    public $order = null;

    public function run()
    {
        if (Yii::app()->viewed->count() == 0) {
            return false;
        }

        $viewed = Yii::app()->viewed->get();

        $criteria = new CDbCriteria();
        $criteria->scopes = ['published'];
        $criteria->addInCondition('t.id', array_keys($viewed));

        if (!is_null($this->limit)) {
            $criteria->limit = $this->limit;
        }

        if (is_null($this->order)) {
            arsort($viewed);
            $criteria->order = 'FIELD(id, ' . implode(',', array_keys($viewed)) . ')';
        } else {
            $criteria->order = $this->order;
        }

        $this->render($this->view, [
            'products' => Product::model()->findAll($criteria),
        ]);

        return true;
    }
}
<?php
Yii::import('application.modules.store.models.Producer');

/**
 * Class ProducersWidget
 */
class ProducersWidget extends \yupe\widgets\YWidget
{
    /**
     * @var int
     */
    public $limit = -1;
    /**
     * @var string
     */
    public $order = 'id ASC';
    /**
     * @var string
     */
    public $view = 'default';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render(
            $this->view,
            [
                'brands' => Producer::model()->getAll($this->limit, $this->order),
            ]
        );
    }
}
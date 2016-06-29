<?php

/**
 * Class ProducerFilterWidget
 */
class ProducerFilterWidget extends \yupe\widgets\YWidget
{
    /**
     * @var int
     */
    public $limit = -1;

    /**
     * @var string
     */
    public $order = 'sort ASC';

    /**
     * @var string
     */
    public $view = 'producer-filter';

    /**
     * @var StoreCategory
     */
    public $category;

    /**
     * @var ProducerRepository
     */
    protected $producerRepository;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->producerRepository = Yii::app()->getComponent('producerRepository');

        parent::init();
    }

    /**
     * @throws CException
     */
    public function run()
    {
        $criteria = new CDbCriteria([
            'limit' => $this->limit,
            'order' => $this->order,
            'scopes' => ['published']
        ]);

        if (null === $this->category) {
            $producers = Producer::model()->findAll($criteria);
        } else {
            $producers = $this->producerRepository->getForCategory($this->category, $criteria);
        }

        $this->render($this->view, [
            'producers' => $producers
        ]);
    }
} 

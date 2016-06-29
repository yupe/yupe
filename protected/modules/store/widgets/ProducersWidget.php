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
    public $order = 'sort ASC';
    /**
     * @var string
     */
    public $view = 'default';

    /**
     * @var StoreCategory
     */
    public $category;

    /**
     * @var string
     */
    public $title = '';

    /**
     * @var ProducerRepository
     */
    protected $producerRepository;

    public function init()
    {
        $this->producerRepository = Yii::app()->getComponent('producerRepository');

        if (!$this->title) {
            $this->title = Yii::t('StoreModule.store', 'Producers list');
        }

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
            'brands' => $producers,
            'title' => $this->title
        ]);
    }
}
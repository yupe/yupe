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

    /**
     *
     */
    public function init()
    {
        parent::init();

        $this->producerRepository = Yii::app()->getComponent('producerRepository');

        if (!$this->title) {
            $this->title = Yii::t('StoreModule.store', 'Producers list');
        }
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

        $this->render($this->view, [
            'brands' => $this->category ? $this->producerRepository->getForCategory($this->category, $criteria) : Producer::model()->findAll($criteria),
            'title' => $this->title
        ]);
    }
}
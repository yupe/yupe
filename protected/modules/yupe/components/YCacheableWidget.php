<?php
/**
 *  class YCacheableWidget - main class for all cached widget
 *
 *  "Кэширующий" виджет
 *
 * @package widgets
 * @author Opeykin A. <aopeykin@yandex.ru>
 * @version 0.0.1
 * @link http://allframeworks.ru
 *
 */
class YCacheableWidget extends CWidget
{
    /**
     * $criteria - экземпляр CDbCriteria для выборки данных
     * @var CDbCriteria
     */
    public $criteria = null;
    /**
     * $cacheDuration - время жизни кэша
     * @var int
     */
    public $cacheDuration = 3600;
    /**
     * $cacheComponent - название компонента Yii::app(), который будет производить кэширование
     * @var string
     */
    public $cacheComponent = 'cache';
    /**
     * $cacheName - название фрагмета кэша, которое будет использовано при кэшировании данных
     * если данный параметр не передан - уникальное название будет сгенерировано автоматически
     * @var string
     */
    public $cacheName;
    /**
     * $prefix - часть имени класса виджета, по которому будет определяться название используемой модели и вьюхи
     * например, если класс виджета имеет название UserSomeWidget, а префикс = 'SomeWidget', то
     * будет использована модель User и вьюха User
     * @var string
     */
    public $prefix = 'Widget';

    public $dependency;
    public $view;
    public $model;
    public $data;

    protected function getMagicName()
    {
        $className = get_class($this);
        return substr($className, 0, strpos($className, $this->prefix));
    }

    public function run()
    {
        // если не указали вьюху напрямую - берем ее из имени класса
        if (!$this->view)
            $this->view = $this->getMagicName();

        // если данные не переданы напрямую - используем модель
        if (!$this->data)
        {
            // разберемся с моделью
            $model = (!$this->model) ? $this->getMagicName() : $this->model;

            if (is_a($this->criteria, 'CDbCriteria'))
                $this->criteria = new CDbCriteria();
            else if (is_array($this->criteria))
                $this->criteria = new CDbCriteria($this->criteria);

            // получить название кэша, так как виджет может вызываться с разными параметрами
            // имя фрагмента в кэше должно учитывать все параметры виджета (CDbCriteria + $this->view)
            // название вьюхи решил убрать из имени кэша, что бы можно было использовать
            // кэшированные данные с разными вьюхами
            $cacheName = $this->cacheName ? $this->cacheName : md5(serialize($this->criteria));
        }
        else
            $cacheName = $this->cacheName ? $this->cacheName : md5(serialize($this->data));

        // название компонента кэша
        $cachec = $this->cacheComponent;
        // попытка чтения из кэша
        $data   = Yii::app()->$cachec->get($cacheName);
        if (!$data)
        {
            // получение данных из базы (или данных переданных в виджет) и запись их в кэш
            $data = $this->data ? $this->data : $model::model()->findAll($this->criteria);
            $this->cacheDuration = (int) $this->cacheDuration;
            Yii::app()->$cachec->set($cacheName, $data, $this->cacheDuration, $this->dependency);
        }
        $this->render($this->view, array('data' => $data));
    }
}
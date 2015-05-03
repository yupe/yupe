<?php
/**
 * Класс управления состояниями фильтра данных
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components
 *
 * @author   Oleg Filimonov <olegsabian@gmail.com>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru - основной сайт
 *
 **/
namespace yupe\components;

use Yii;
use yupe\models\YModel;

class FilterState
{
    private $model;
    private $prefix;
    private $request;

    public function __construct(YModel $model)
    {
        $this->model = $model;
        $this->prefix = get_class($model);
        $this->request = Yii::app()->getRequest();
    }

    public function run()
    {
        if ($this->request->getQuery('clearFilters') == 1) {
            $this->clear();
        }

        $query = $this->request->getQuery($this->prefix);

        if (isset($query)) {
            $this->model->attributes = $query;
            $this->setValues();
        } else {
            $this->getValues();
        }

        $this->setControls('page');
        $this->setControls('sort');
    }

    /**
     * Очищает все значения фильтра
     */
    public function clear()
    {
        $this->model->unsetAttributes();

        foreach ($this->getAttributes() as $attribute) {
            $this->setValue($attribute);
        }

        $this->setValue('page');
        $this->setValue('sort');
    }

    /**
     * Возвращает все безопасные атрибуты модели
     *
     * @return array
     */
    private function getAttributes()
    {
        return $this->model->getSafeAttributeNames();
    }

    /**
     * Возвращает значение атрибута из сессии пользователя
     *
     * @param $name
     * @return mixed
     */
    private function getValue($name)
    {
        return Yii::app()->user->getState($this->prefix . $name);
    }

    /**
     * Записывает значение атрибута в сессию пользователя
     *
     * @param $name
     * @param int $value
     */
    private function setValue($name, $value = 1)
    {
        Yii::app()->user->setState($this->prefix . $name, $value, 1);
    }

    /**
     * Массовое присваивание сохраненных значений атрибутам модели
     */
    private function getValues()
    {
        foreach ($this->getAttributes() as $attribute) {
            if (null !== ($value = $this->getValue($attribute))) {
                $this->model->$attribute = $value;
            }
        }
    }

    /**
     * Сохранение всех значений атрибутов модели
     */
    private function setValues()
    {
        foreach ($this->getAttributes() as $attribute) {
            $this->setValue($attribute, $this->model->$attribute);
        }
    }

    /**
     * Управление значениями не являющимися атрибутами модели (сортировка, пагинация)
     *
     * @param $name
     */
    private function setControls($name)
    {
        $key = $this->prefix . '_' . $name;
        $query = $this->request->getQuery($key);

        if (!empty($query)) {
            $this->setValue($name, $query);
        } elseif (!empty($_GET['ajax'])) {
            $this->setValue($name);
        } else {
            $val = $this->getValue($name);
            if (!empty($val)) {
                $_GET[$key] = $val;
            }
        }
    }
}
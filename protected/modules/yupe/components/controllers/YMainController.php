<?php
/**
 * Содержит общие функции для панели управления и фронтенда
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   aopeykin <aopeykin@yandex.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/

 /**
 * Содержит общие функции для панели управления и фронтенда
 *
 * @category YupeComponents
 * @package  YupeCMS
 * @author   aopeykin <aopeykin@yandex.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     http://yupe.ru
 **/
class YMainController extends Controller
{
    public $yupe;
    public $headerTypeId = YContentType::TYPE_HTML;

    /**
     * Функци определяющая мультиязычность:
     *
     * @return bool isMultilang
     **/
    public function isMultilang()
    {
        return isset(Yii::app()->urlManager->languages) && is_array(Yii::app()->urlManager->languages);
    }

    /**
     * Функция инициализации контроллера:
     *
     * @return nothing
     **/
    public function init()
    {
        parent::init();
        $this->yupe = Yii::app()->getModule('yupe');
    }

    /**
     * Функция отрисовки виджета:
     *
     * @param string $className     - имя класса
     * @param mixed  $properties    - параметры
     * @param bool   $captureOutput - требуется ли "захват" вывода виджета
     *
     * @return Инстанс виджета в случае, когда $captureOutput является ложным,
     *         или вывод виджета, когда $captureOutput - истина
     **/
    public function widget($className, $properties = array(), $captureOutput = false)
    {
        if (stripos($className, 'application.modules.', 0) !== false) {
            //@TODO попробовать без регулярки
            $module = preg_replace('/^application\.modules\.([^\.]*).*$/', '$1', $className);

            if (Yii::app()->getModule($module) == null) {
                echo Yii::t(
                    'YupeModule.yupe', 'Виджет "{widget}" не найден! Подключите модуль "{module}" !', array(
                        '{widget}' => $className,
                        '{module}' => $module
                    )
                );
                return;
            }
        }
        parent::widget($className, $properties, $captureOutput);
    }

    /**
     * Действие обработки вывода:
     *
     * @param string $output - буфер для вывода
     *
     * @return function родительский вызов processOutput
     **/
    public function processOutput($output)
    {
        YContentType::setHeader($this->headerTypeId);
        return parent::processOutput($output);
    }
}
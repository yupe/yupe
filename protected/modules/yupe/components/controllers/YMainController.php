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
 * @version  0.1
 * @link     http://yupe.ru
 **/
class YMainController extends Controller
{
    public $yupe;

    public $headerTypeId = YContentType::TYPE_HTML;

    /**
     * Устанавливает заголовок страниц
     * @param string $title заголовок
     */
    public function setPageTitle($title,$savePrev=false,$separator='|')
    {
        if($savePrev)
            $this->pageTitle = $this->pageTitle . CHtml::encode($separator) . CHtml::encode($title);
        else
            $this->pageTitle = CHtml::encode($title);
    }

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
     * @return void
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
     * @return mixed Инстанс виджета в случае, когда $captureOutput является ложным,
     * или вывод виджета, когда $captureOutput - истина
     **/
    public function widget($className, $properties = array(), $captureOutput = false)
    {
        if (stripos($className, 'application.modules') !== false) {

            $modulePath = explode('.', $className);

            if (!empty($modulePath[2]) && !Yii::app()->hasModule($modulePath[2])) {
                echo CHtml::tag(
                    'p', array(
                        'class' => 'alert alert-error'
                    ), Yii::t(
                        'YupeModule.yupe', 'Виджет "{widget}" не найден! Подключите модуль "{module}" !', array(
                            '{widget}' => $className,
                            '{module}' => $modulePath[2]
                        )
                    )
                );
                return null;
            }
        }
        return parent::widget($className, $properties, $captureOutput);
    }

    /**
     * Действие обработки вывода:
     *
     * @param string $output - буфер для вывода
     *
     * @return string родительский вызов processOutput
     **/
    public function processOutput($output)
    {
        YContentType::setHeader($this->headerTypeId);
        return parent::processOutput($output);
    }

    /**
     * Отключение всех профайлеров и логгеров, используется, например при загрузке файлов
     *
     * @since 0.5
     * @see http://allframeworks.ru/blog/Yii/371.html
     **/
    public function disableProfilers()
    {
        if (Yii::app()->getComponent('log')) {
            foreach (Yii::app()->getComponent('log')->routes as $route) {
                if (in_array(get_class($route), array('CFileLogRoute','CProfileLogRoute', 'CWebLogRoute', 'YiiDebugToolbarRoute','DbProfileLogRoute'))) {
                    $route->enabled = false;
                }
            }
        }
    }
}
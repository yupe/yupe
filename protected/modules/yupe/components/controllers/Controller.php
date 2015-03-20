<?php
/**
 * Общий контроллер для панели управления и фронтенда
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components.controllers
 * @author   aopeykin <aopeykin@yandex.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.6
 * @link     http://yupe.ru
 **/

namespace yupe\components\controllers;

use yupe\components\ContentType;
use CHtml;
use Yii;
use CException;
use CHttpException;
use yupe\widgets\YWidget;

/**
 * Class Controller
 * @package yupe\components\controllers
 *
 * @property string|array $title
 * @property string $metaDescription
 * @property string $metaKeywords
 * @property array $metaProperties
 * @property string $canonical
 */
abstract class Controller extends \CController
{
    /**
     * @var \YupeModule
     */
    public $yupe;

    /**
     * @var
     */
    public $layout;

    /**
     * Хлебные крошки сайта, меняется в админке
     */
    public $breadcrumbs = [];

    /**
     * Contains data for "CMenu" widget (provides view for menu on the site)
     */
    public $menu = [];

    /**
     * Тип заголовка, подробнее в yupe\components\ContentType
     * @var integer
     */
    public $headerTypeId = ContentType::TYPE_HTML;

    public function behaviors()
    {
        return array(
            'seo' => array('class' => 'vendor.chemezov.yii-seo.behaviors.SeoBehavior'),
        );
    }

    /**
     * For backward capability
     *
     * @deprecated
     * @param string $value
     */
    public function setDescription($value)
    {
        $this->metaDescription = $value;
    }

    /**
     * For backward capability
     *
     * @deprecated
     * @param string $value
     */
    public function setKeywords($value)
    {
        $this->metaKeywords = $value;
    }

    /**
     * Функци определяющая мультиязычность:
     *
     * @return bool
     **/
    public function isMultilang()
    {
        return isset(Yii::app()->getUrlManager()->languages) && is_array(Yii::app()->getUrlManager()->languages);
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
     * @param string $className - имя класса
     * @param mixed $properties - параметры
     * @param bool $captureOutput - требуется ли "захват" вывода виджета
     *
     * @return mixed Инстанс виджета в случае, когда $captureOutput является ложным,
     *               или вывод виджета, когда $captureOutput - истина
     **/
    public function widget($className, $properties = [], $captureOutput = false)
    {
        try {

            $modulePath = explode('.', $className);

            $isModule = strpos($className, 'application.modules') !== false
                && !empty($modulePath[2])
                && !Yii::app()->hasModule($modulePath[2]);

            if (false === Yii::getPathOfAlias($className) || $isModule) {

                if ($isModule) {
                    throw new CException(
                        Yii::t(
                            'YupeModule.yupe',
                            'Widget "{widget}" was not found! Please enable "{module}" module!',
                            [
                                '{widget}' => $className,
                                '{module}' => $modulePath[2]
                            ]
                        ), 1
                    );
                } elseif (class_exists($className) === false) {

                    throw new CException(
                        Yii::t(
                            'YupeModule.yupe',
                            'Widget "{widget}" was not found!',
                            [
                                '{widget}' => $className,
                            ]
                        )
                    );
                }
            }

            $widget = parent::widget($className, $properties, $captureOutput);

        } catch (CException $e) {

            echo CHtml::tag(
                'p',
                [
                    'class' => 'alert alert-danger'
                ],
                $e->getCode()
                    ? $e->getMessage()
                    : Yii::t(
                    'YupeModule.yupe',
                    'Error occurred during the render widget ({widget}): {error}',
                    [
                        '{error}'  => $e->getMessage(),
                        '{widget}' => $className,
                    ]
                )
            );

            return null;

        }

        return $widget;
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
        ContentType::setHeader($this->headerTypeId);

        return parent::processOutput($output);
    }

    /**
     * Если вызван ошибочный запрос:
     *
     * @param string $message - сообщение
     * @param integer $error - код ошибки
     *
     * @return void
     */
    protected function badRequest($message = null, $error = 400)
    {
        // Если сообщение не установленно - выставляем
        // дефолтное
        $message = $message
            ?: Yii::t(
                'YupeModule.yupe',
                'Bad request. Please don\'t use similar requests anymore!'
            );

        if (Yii::app()->getRequest()->getIsAjaxRequest() === true) {
            return Yii::app()->ajax->failure($message);
        }

        throw new CHttpException($error, $message);
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
                if (in_array(
                    get_class($route),
                    [
                        'CFileLogRoute',
                        'CProfileLogRoute',
                        'CWebLogRoute',
                        'YiiDebugToolbarRoute',
                        'DbProfileLogRoute'
                    ]
                )
                ) {
                    $route->enabled = false;
                }
            }
        }
    }
}

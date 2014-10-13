<?php
/**
 * Базовый класс для всех контроллеров публичной части
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components.controllers
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.6
 * @link     http://yupe.ru
 **/

namespace yupe\components\controllers;

use Yii;
use yupe\events\YupeControllerInitEvent;
use yupe\events\YupeEvents;

/**
 * Class FrontController
 * @package yupe\components\controllers
 */
abstract class FrontController extends Controller
{
    /**
     * Вызывается при инициализации FrontController
     * Присваивает значения, необходимым переменным
     */
    public function init()
    {
        Yii::app()->eventManager->fire(YupeEvents::BEFORE_FRONT_CONTROLLER_INIT,  new YupeControllerInitEvent($this, Yii::app()->getUser()));

        parent::init();

        $this->pageTitle = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;
        $this->keywords = $this->yupe->siteKeyWords;

        Yii::app()->theme = $this->yupe->theme ? : 'default';

        $bootstrap = Yii::app()->getTheme()->getBasePath() . DIRECTORY_SEPARATOR . "bootstrap.php";

        if (is_file($bootstrap)) {
            require $bootstrap;
        }
    }
}

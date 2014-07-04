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

/**
 * Class FrontController
 * @package yupe\components\controllers
 */
class FrontController extends Controller
{
    /**
     * @var
     */
    private $_assetsUrl;

    /**
     * @return mixed
     */
    public function getAssetsUrl()
    {
        if (null === $this->_assetsUrl) {
            $this->_assetsUrl = Yii::app()->getAssetManager()->publish(
                Yii::app()->theme->basePath . DIRECTORY_SEPARATOR . 'web'
            );
        }

        return $this->_assetsUrl;
    }

    /**
     * Вызывается при инициализации FrontController
     * Присваивает значения, необходимым переменным
     */
    public function init()
    {
        parent::init();
        $this->pageTitle = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;
        $this->keywords = $this->yupe->siteKeyWords;
        if ($this->yupe->theme) {
            Yii::app()->theme = $this->yupe->theme;
            $bootstrap = Yii::app()->theme->basePath . DIRECTORY_SEPARATOR . "bootstrap.php";
            if (is_file($bootstrap)) {
                require $bootstrap;
            }
        } else {
            Yii::app()->theme = 'default';
        }
    }
}
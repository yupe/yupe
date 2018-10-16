<?php

/**
 * Yii Extended Captcha
 * Класс реализующий Капчу, параметры длинны которой извлекаются
 * из настроек модуля.
 *
 * @category YupeComponents
 * @package  yupe.modules.yupe.components.actions
 * @author   Anton Kucherov <idexter.ru@gmail.com>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.1
 * @link     http://yupe.ru
 **/
namespace yupe\components\actions;

use CCaptchaAction;

/**
 * Class YCaptchaAction
 * @package yupe\components\actions
 */
class YCaptchaAction extends CCaptchaAction
{
    /**
     * @var int|mixed
     */
    public $minLength = 3;
    /**
     * @var int|mixed
     */
    public $maxLength = 6;

    /**
     * @param \CController $controller
     * @param string $id
     */
    public function __construct($controller, $id)
    {
        parent::__construct($controller, $id);

        $module = $controller->getModule();

        if ($module && property_exists($module, "minCaptchaLength")) {
            $this->minLength = $module->minCaptchaLength;
        }
        if ($module && property_exists($module, "maxCaptchaLength")) {
            $this->maxLength = $module->maxCaptchaLength;
        }
    }

}

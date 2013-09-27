<?php
/**
 * Контроллер отвечающий за front - часть
 * 
 * @category YupeComponents
 * @package  yupe
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.6
 * @link     http://yupe.ru
 **/

namespace yupe\components\controllers;

use Yii;

class FrontController extends Controller
{
    /**
     * Вызывается при инициализации FrontController
     * Присваивает значения, необходимым переменным
     */
    public function init()
    {
        parent::init();
        $this->pageTitle   = $this->yupe->siteName;
        $this->description = $this->yupe->siteDescription;
        $this->keywords    = $this->yupe->siteKeyWords;
        if ($this->yupe->theme) {
            Yii::app()->theme = $this->yupe->theme;
        }
        else {
            Yii::app()->theme = 'default';
        }
    }
}
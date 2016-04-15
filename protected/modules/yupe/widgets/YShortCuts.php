<?php
/**
 * Виджет панели быстрого запуска:
 *
 * @category YupeWidget
 * @package  yupe.modules.yupe.widgets
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
namespace yupe\widgets;

use Yii;

/**
 * Class YShortCuts
 * @package yupe\widgets
 */
class YShortCuts extends YWidget
{
    /**
     * @var
     */
    public $modules;

    /**
     * @var string
     */
    public $view = 'shortcuts';

    /**
     *
     */
    public function run()
    {
        $this->render(
            $this->view,
            ['modules' => $this->modules, 'updates' => Yii::app()->migrator->checkForUpdates($this->modules)]
        );
    }
}

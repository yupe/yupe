<?php
/**
 * Виджет админ-панели для фронтальной части сайта
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
use CHtml;

class YAdminPanel extends YWidget
{
    public $view = 'adminpanel';

    public function run()
    {
        $this->render(
            $this->view,
            [
                'modules' => Yii::app()->moduleManager->getModules(true)
            ]
        );
    }
}

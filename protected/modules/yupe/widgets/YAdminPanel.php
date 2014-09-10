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
use CClientScript;
use TagsCache;

class YAdminPanel extends YWidget
{
    public $view = 'application.modules.yupe.views.widgets.YAdminPanel.adminpanel';

    public function run()
    {
        $cacheKey = 'YAdminPanel::' . Yii::app()->getUser()->getId() . '::' . Yii::app()->getLanguage();

        $cached = Yii::app()->getCache()->get($cacheKey);

        if (false === $cached) {
            $cached = $this->render(
                $this->view,
                [
                    'modules' => Yii::app()->moduleManager->getModules(true),
                    'yupe' => $this->getController()->yupe
                ],
                true
            );
            Yii::app()->getCache()->set(
                $cacheKey,
                $cached,
                0,
                new TagsCache('yupe', 'YAdminPanel', 'installedModules')
            );
        }

        echo $cached;
    }
}

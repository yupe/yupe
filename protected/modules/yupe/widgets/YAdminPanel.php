<?php
/**
 * Виджет админ-панели для фронтсайда:
 *
 * @category YupeWidget
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/
class YAdminPanel extends YWidget
{
    /**
     * Запуск виджета
     *
     * @return void
     **/
    public function run()
    {
        if (Yii::app()->user->isSuperUser())
            $this->render('application.modules.yupe.views.widgets.YAdminPanel.adminpanel');
    }
}
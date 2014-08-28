<?php

/**
 * Виджет вывода поля для поискового запроса
 *
 * @category YupeWidget
 * @package  yupe.modules.zendsearch.widgets
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class SearchBlockWidget extends yupe\widgets\YWidget
{
    public $view = 'searchblockwidget';

    public function run()
    {
        $this->render($this->view);
    }
}

<?php

/**
 *
 * Файл конфигурации модуля
 *
 * @category YupeForms
 * @package  yupe.modules.install.install
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @version  0.0.1
 * @link     https://yupe.ru
 **/
class GetHelpWidget extends yupe\widgets\YWidget
{
    public $view = 'gethelpwidget';

    public function run()
    {
        $this->render($this->view);
    }

}

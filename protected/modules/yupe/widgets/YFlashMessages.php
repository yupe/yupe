<?php
/**
 * Виджет для отображения flash-сообщений
 *
 * @category YupeWidget
 * @package  yupe.modules.yupe.widgets
 * @author   Yupe Team <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/
namespace yupe\widgets;

class YFlashMessages extends YWidget
{
    const SUCCESS_MESSAGE = 'success';
    const INFO_MESSAGE = 'info';
    const WARNING_MESSAGE = 'warning';
    const ERROR_MESSAGE = 'error';

    public $options = [];

    public $view = 'flashmessages';

    public function run()
    {
        $this->render($this->view, ['options' => $this->options]);
    }
}

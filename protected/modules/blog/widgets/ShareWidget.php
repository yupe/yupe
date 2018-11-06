<?php

/**
 * ShareWidget виджет для вывода кнопок "поделиться"
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.blog.widgets
 * @since 0.1
 *
 */
class ShareWidget extends yupe\widgets\YWidget
{
    /**
     * @var string
     */
    public $view = 'share';

    /**
     * @throws CException
     */
    public function run()
    {
        $this->render($this->view);
    }
}

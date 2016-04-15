<?php

/**
 * YQueue базовый класс для всех очередей
 *
 * @author yupe team <team@yupe.ru>
 * @link http://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.queue.components
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 * @abstract
 *
 */
abstract class YQueue extends CApplicationComponent implements YQueueInterface
{
    /**
     *
     */
    public function init()
    {
        parent::init();
    }
}

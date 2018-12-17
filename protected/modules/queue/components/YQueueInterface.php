<?php

/**
 * YQueueInterface интерфейс для всех очередей
 *
 * @author yupe team <team@yupe.ru>
 * @link https://yupe.ru
 * @copyright 2009-2013 amyLabs && Yupe! team
 * @package yupe.modules.queue.components
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @since 0.1
 * @abstract
 *
 */
interface YQueueInterface
{
    /**
     * @param $worker
     * @param array $task
     * @return mixed
     */
    public function add($worker, array $task);

    /**
     * @param null $worker
     * @return mixed
     */
    public function flush($worker = null);
}

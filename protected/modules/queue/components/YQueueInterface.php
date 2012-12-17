<?php

interface YQueueInterface
{
    public function add($worker, array $task);
    public function flush($worker = null);
}
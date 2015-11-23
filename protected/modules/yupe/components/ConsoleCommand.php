<?php

namespace yupe\components;

use CConsoleCommand;
use CLogger;
use Yii;


/**
 * Class ConsoleCommand
 */
abstract class ConsoleCommand extends CConsoleCommand
{
    /**
     * @var string
     */
    public $cache = 'cache';

    /**
     * @var bool
     */
    public $echo = true;

    /**
     * @return mixed
     */
    public function getCache()
    {
        if (is_object($this->cache)) {
            return $this->cache;
        }

        if (!Yii::app()->hasComponent($this->cache)) {
            throw new \CException('Please set valid "cache" component!');
        }

        $this->cache = Yii::app()->getComponent($this->cache);

        return $this->cache;
    }

    /**
     * @return string
     */
    public function getLogCategory()
    {
        return get_class($this);
    }

    /**
     * @param $message
     * @param string $level
     * @param bool $echo
     * @param null $category
     */
    public function log($message, $level = CLogger::LEVEL_INFO, $echo = true, $category = null)
    {
        if (null === $category) {
            $category = $this->getLogCategory();
        }

        if ($echo || $this->echo) {
            echo "{$message}\n";
        }

        Yii::log($message, $level, $category);
    }

    /**
     * @param null $message
     */
    public function end($message = null)
    {
        if ($message) {
            $this->log($message, CLogger::LEVEL_ERROR);
        }

        Yii::app()->end();
    }

    /**
     * @param int $time
     */
    public function lock($time = 3600)
    {
        $this->log(sprintf('Lock command "%s" for time %d', get_class($this), $time));

        $this->getCache()->set(sprintf('yupe::command::run::%s', get_class($this)), 'locked', (int)$time);
    }

    /**
     * @return mixed
     */
    public function isLocked()
    {
        $lock = $this->getCache()->get(sprintf('yupe::command::run::%s', get_class($this)));

        if (false !== $lock) {
            $this->log(sprintf('Command "%s" is locked', get_class($this)));
        }

        return $lock;
    }

    /**
     *
     */
    public function unlock()
    {
        $this->log(sprintf('Unlock command "%s"', get_class($this)));

        $this->getCache()->delete(sprintf('yupe::command::run::%s', get_class($this)));
    }

    public function endIfLocked($message = null)
    {
        if ($this->isLocked()) {
            $this->end($message);
        }
    }
}

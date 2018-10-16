<?php

/**
 * TagsCache dependency class:
 *
 * @category YupeComponent
 * @package  yupe.modules.yupe.extensions.tagcache
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
class TagsCache implements ICacheDependency
{

    /**
     * @var
     */
    protected $timestamp;
    /**
     * @var array
     */
    protected $tags;

    /**
     * TagsCache constructor.
     */
    public function __construct()
    {
        $this->tags = func_get_args();
    }

    /**
     * Evaluates the dependency by generating and saving the data related with dependency.
     * This method is invoked by cache before writing data into it.
     *
     * @return void
     */
    public function evaluateDependency()
    {
        $this->timestamp = microtime(true);
    }

    /**
     * is dependency changed
     *
     * @return boolean whether the dependency has changed.
     */
    public function getHasChanged()
    {
        $tags = [];

        foreach ($this->tags as $tag) {
            $tags[] = TaggingCacheBehavior::PREFIX.$tag;
        }

        $values = Yii::app()->getCache()->mget($tags);

        foreach ($values as $value) {
            if ((float)$value > $this->timestamp) {
                return true;
            }
        }

        return false;
    }
}

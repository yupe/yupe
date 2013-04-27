<?php
/**
 * Tagging cache behavior class:
 *
 * @category YupeComponent
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.1 (dev)
 * @link     http://yupe.ru
 *
 **/
class TaggingCacheBehavior extends CBehavior
{

    const PREFIX = '__tag__';

    /**
     * Инвалидирует данные, помеченные тегом(ами)
     *
     * @param string $tags - теги кеша
     * 
     * @return void
     */
    public function clear($tags)
    {
        foreach ((array) $tags as $tag)
            $this->owner->set(self::PREFIX.$tag, microtime(true));

        Yii::log(
            Yii::t(
                'YupeModule.yupe', 'Инвалидированы теги: {tags}', array(
                    '{tags}' => implode(', ', (array) $tags)
                )
            )
        );
    }
}
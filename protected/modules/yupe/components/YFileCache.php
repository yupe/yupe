<?php
/**
 * Файл класса кеширования превью изображений:
 *
 * @category YupeComponent
 * @package  YupeCMS
 * @author   AKulikov <tuxuls@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1 (dev)
 * @link     http://yupe.ru
 *
 **/
class YFileCache extends CFileCache
{
    /**
     * Deletes all values from cache.
     * This is the implementation of the method declared in the parent class.
     * 
     * @return boolean whether the flush operation was successful.
     */
    protected function flushValues()
    {
        /**
         * Очистка превьюшек (так как кеш мёртв, а превьюшки остались)
         */
        foreach (glob(Yii::app()->getModule('image')->getUploadPath() . 'thumbs_cache_yupe_*') as $file)
            @unlink($file);
        
        return parent::flushValues();
    }
}
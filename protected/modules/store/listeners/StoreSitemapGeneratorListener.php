<?php

use yupe\components\Event;

Yii::import('application.modules.store.models.Product');

/**
 * Class StoreSitemapGeneratorListener
 */
class StoreSitemapGeneratorListener
{
    /**
     * @param Event $event
     */
    public static function onGenerate(Event $event)
    {
        $generator = $event->getGenerator();

        $provider = new CActiveDataProvider(Product::model()->published());

        foreach (new CDataProviderIterator($provider) as $item) {
            $generator->addItem(
                ProductHelper::getUrl($item, true),
                strtotime($item->update_time),
                SitemapHelper::FREQUENCY_DAILY,
                0.5
            );
        }

        $brandProvider = new CActiveDataProvider(Producer::model()->published());

        foreach (new CDataProviderIterator($brandProvider) as $item) {
            $generator->addItem(
                Yii::app()->createAbsoluteUrl('/store/producer/view', ['slug' => $item->slug]),
                null,
                SitemapHelper::FREQUENCY_DAILY,
                0.5
            );
        }


        $categoryProvider = new CActiveDataProvider(StoreCategory::model()->published());

        foreach (new CDataProviderIterator($categoryProvider) as $item) {
            $generator->addItem(
                Yii::app()->createAbsoluteUrl('/store/category/view', ['path' => $item->path]),
                null,
                SitemapHelper::FREQUENCY_DAILY,
                0.5
            );
        }
    }
} 

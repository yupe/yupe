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
                Yii::app()->createAbsoluteUrl('/store/product/view', ['name' => $item->slug]),
                strtotime($item->update_time),
                SitemapHelper::FREQUENCY_DAILY,
                0.5
            );
        }
    }
} 

<?php

use yupe\components\Event;

Yii::import('application.modules.page.models.Page');

/**
 * Class SitemapGeneratorListener
 */
class PageSitemapGeneratorListener
{
    /**
     * @param Event $event
     */
    public static function onGenerate(Event $event)
    {
        $generator = $event->getGenerator();

        $provider = new CActiveDataProvider(Page::model()->published()->public());

        foreach (new CDataProviderIterator($provider) as $item) {
            $generator->addItem(
                Yii::app()->createAbsoluteUrl('/page/page/view', ['slug' => $item->slug]),
                strtotime($item->update_time),
                SitemapHelper::FREQUENCY_WEEKLY,
                0.5
            );
        }
    }
} 

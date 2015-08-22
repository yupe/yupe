<?php

use yupe\components\Event;

Yii::import('application.modules.news.models.News');

/**
 * Class SitemapGeneratorListener
 */
class NewsSitemapGeneratorListener
{
    /**
     * @param Event $event
     */
    public static function onGenerate(Event $event)
    {
        $generator = $event->getGenerator();

        $provider = new CActiveDataProvider(News::model()->published()->public());

        foreach (new CDataProviderIterator($provider) as $item) {
            $generator->addItem(
                Yii::app()->createAbsoluteUrl('/news/news/view', ['slug' => $item->slug]),
                strtotime($item->update_time),
                SitemapHelper::FREQUENCY_WEEKLY,
                0.5
            );
        }
    }
} 

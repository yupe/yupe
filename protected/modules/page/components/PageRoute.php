<?php
Yii::import('application.modules.page.models.*');

class PageRoute
{
    const CACHE_NAME = 'Page::rulesList';
    const CACHE_TAG_NAME = 'yupe::page::rules';

    /**
     * Add PageModule route rules to config on the fly
     */
    public static function add()
    {
        $rules = Yii::app()->cache->get(self::CACHE_NAME);

        if ($rules === false) {
            $rules = [];
            $pages = Page::model()->findAll();

            foreach ($pages as $page) {
                $rules[$page->slug] = 'page/page/view/slug/' . $page->slug;
            }

            Yii::app()->cache->set(self::CACHE_NAME, $rules, 0, new TagsCache(self::CACHE_TAG_NAME));
        }

        Yii::app()->urlManager->addRules($rules);
    }
}
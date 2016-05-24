<?php

/**
 * Class PageBehavior
 */
class PageBehavior extends CBehavior
{
    /**
     *
     */
    const RULES_CACHE_NAME = 'page::rules::list';
    /**
     *
     */
    const RULES_CACHE_TAG_NAME = 'yupe::page::rules';

    /**
     * @return array
     */
    public function events()
    {
        return array_merge(parent::events(), array(
            'onBeginRequest' => 'onBeginRequest',
        ));
    }

    /**
     *
     */
    public function onBeginRequest()
    {
        $rules = Yii::app()->getCache()->get(self::RULES_CACHE_NAME);

        if ($rules === false) {
            $rules = [];
            $pages = Page::model()->findAll();

            foreach ($pages as $page) {
                $rules[$page->slug] = 'page/page/view/slug/'.$page->slug;
            }

            Yii::app()->getCache()->set(self::RULES_CACHE_NAME, $rules, 0, new TagsCache(self::RULES_CACHE_TAG_NAME));
        }

        Yii::app()->getUrlManager()->addRules($rules);
    }
}
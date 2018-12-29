<?php

/**
 * Виджет вывода последних новостей
 *
 * @category YupeWidget
 * @package  yupe.modules.news.widgets
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     https://yupe.ru
 *
 **/
Yii::import('application.modules.news.models.*');

/**
 * Class LastNewsWidget
 */
class LastNewsWidget extends yupe\widgets\YWidget
{
    /** @var $categories mixed Список категорий, из которых выбирать новости. NULL - все */
    public $categories = null;

    /**
     * @var string
     */
    public $view = 'lastnewswidget';

    /**
     * @throws CException
     */
    public function run()
    {
        $cacheName = NewsHelper::CACHE_NEWS_LIST;

        if ($this->controller->isMultilang()) {
            $cacheName .= '::' . Yii::app()->getLanguage();
        }

        $news = Yii::app()->getCache()->get($cacheName);

        if ($news === false) {
            $criteria = new CDbCriteria();
            $criteria->limit = (int)$this->limit;
            $criteria->order = 'date DESC';

            if ($this->categories) {
                if (is_array($this->categories)) {
                    $criteria->addInCondition('category_id', $this->categories);
                } else {
                    $criteria->compare('category_id', $this->categories);
                }
            }

            $news = ($this->controller->isMultilang())
                ? News::model()->published()->language(Yii::app()->getLanguage())->findAll($criteria)
                : News::model()->published()->findAll($criteria);

            Yii::app()->getCache()->set($cacheName, $news, $this->cacheTime, new TagsCache(NewsHelper::CACHE_NEWS_TAG));
        }

        $this->render($this->view, ['models' => $news]);
    }
}

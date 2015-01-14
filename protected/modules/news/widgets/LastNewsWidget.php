<?php

/**
 * Виджет вывода последних новостей
 *
 * @category YupeWidget
 * @package  yupe.modules.news.widgets
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.5.3
 * @link     http://yupe.ru
 *
 **/
Yii::import('application.modules.news.models.*');

class LastNewsWidget extends yupe\widgets\YWidget
{
    /** @var $categories mixed Список категорий, из которых выбирать новости. NULL - все */
    public $categories = null;

    public $view = 'lastnewswidget';

    public function run()
    {
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
            ? News::model()->published()->language(Yii::app()->language)->cache($this->cacheTime)->findAll($criteria)
            : News::model()->published()->cache($this->cacheTime)->findAll($criteria);

        $this->render($this->view, ['models' => $news]);
    }
}

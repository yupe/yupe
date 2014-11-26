<?php

/**
 * Виждет для вывода часто-задаваемых вопросов
 *
 * @category YupeController
 * @package  yupe.modules.feedback.widgets
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
Yii::import('application.modules.feedback.models.FeedBack');

class FaqWidget extends yupe\widgets\YWidget
{
    public $view = 'faqwidget';

    public function run()
    {
        $models = FeedBack::model()->answered()->faq()->cache($this->cacheTime)->findAll(
            [
                'limit' => $this->limit,
                'order' => 'id DESC',
            ]
        );

        $this->render($this->view, ['models' => $models]);
    }
}

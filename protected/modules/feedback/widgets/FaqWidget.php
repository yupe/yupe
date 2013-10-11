<?php
/**
 * Виджет для вывода faq сообщений
 */
class FaqWidget extends YWidget
{
    public $view = 'faqwidget';

    public function run()
    {
        $models = FeedBack::model()->answered()->faq()->cache($this->cacheTime)->findAll(array(
            'limit' => $this->limit,
            'order' => 'id DESC',
        ));

        $this->render($this->view, array('models' => $models));
    }
}
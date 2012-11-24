<?php
/**
 * Created by JetBrains PhpStorm.
 * User: aopeykin
 * Date: 13.06.12
 * Time: 11:17
 * To change this template use File | Settings | File Templates.
 */
class FaqWidget extends YWidget
{
    public function run()
    {
        $models = FeedBack::model()->answered()->faq()->cache($this->cacheTime)->findAll(array(
            'limit' => $this->limit,
            'order' => 'id DESC',
        ));

        $this->render('faqwidget', array('models' => $models));
    }
}
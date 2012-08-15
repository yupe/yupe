<?php
class LastNewsWidget extends YWidget
{
    public $count = 5;

    public function run()
    {

        if ( $this->controller->isMultilang() )
            $news = News::model()->published()->language(Yii::app()->language)->cache($this->cacheTime)->findAll(array(
                'limit' => $this->count,
                'order' => 'date DESC',
            ));
        else
            $news = News::model()->published()->cache($this->cacheTime)->findAll(array(
                'limit' => $this->count,
                'order' => 'date DESC',
            ));


        $this->render('news', array('models' => $news));
    }
}
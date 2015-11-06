<?php
Yii::import('application.modules.store.models.Producer');

class ProducersWidget extends \yupe\widgets\YWidget
{
    public $view = 'default';

    public function run()
    {
        $this->render($this->view, [
            'brands' => Producer::model()->getAll()
        ]);
    }
}
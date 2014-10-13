<?php

class PanelUpdateWidget extends \yupe\widgets\YWidget
{
    public function run()
    {
        $this->render('panel-update', [ 'count' => Yii::app()->updateManager->getUpdatesCount() ]);
    }
} 

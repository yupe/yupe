<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
        'brand' => Yii::app()->name,
        'items' => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => $this->params['items']
            )
        )
    ))
;?>
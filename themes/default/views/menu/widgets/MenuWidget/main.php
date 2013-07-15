<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
        'brand'       => CHtml::image(
            Yii::app()->baseUrl.'/web/images/logo.png',
            Yii::app()->name,
            array(
                'width'  => '38',
                'height' => '38',
                'title'  => Yii::app()->name,
            )
        ),
        'items' => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => $this->params['items']
            )
        )
    ))
;?>
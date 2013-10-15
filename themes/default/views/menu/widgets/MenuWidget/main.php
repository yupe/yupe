<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
        'brand' => CHtml::image(
            Yii::app()->baseUrl . '/web/images/logo.png',
            Yii::app()->name,
            array(
                'width'  => '30',
                'height' => '30',
                'title'  => Yii::app()->name,
            )
        ),
        'brandUrl' => array('/' . Yii::app()->defaultController . '/index/'),
        'items' => array(
            array(
                'class' => 'bootstrap.widgets.TbMenu',
                'items' => array_merge($this->params['items'], $this->controller->yupe->getLanguageSelectorArray())
            )
        )
    ));
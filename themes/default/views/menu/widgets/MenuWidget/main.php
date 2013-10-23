<?php
$this->widget('bootstrap.widgets.TbNavbar', array(
    'collapse' => true,
    'brand' => CHtml::image(
        Yii::app()->baseUrl . '/web/images/logo.png',
        Yii::app()->name,
        array(
            'width' => '38',
            'height' => '38',
            'title' => Yii::app()->name,
        )
    ),
    'brandUrl' => array('/' . Yii::app()->defaultController . '/index/'),
    'items' => array(
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => $this->params['items'],
        ),
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'items' => $this->controller->yupe->getLanguageSelectorArray(),
            'htmlOptions' => array(
                'class' => 'pull-right',
            ),
        )
    ),
));
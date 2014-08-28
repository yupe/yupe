<?php
Yii::import('application.modules.menu.components.YMenu');
$this->widget(
    'bootstrap.widgets.TbNavbar',
    array(
        'collapse' => true,
        'brand'    => CHtml::image(
                Yii::app()->getTheme()->getAssetsUrl() . '/images/logo.png',
                Yii::app()->name,
                array(
                    'width'  => '38',
                    'height' => '38',
                    'title'  => Yii::app()->name,
                )
            ),
        'brandUrl' => '/',
        'items'    => array(
            array(
                'class' => 'YMenu',
                'type'  => 'navbar',
                'items' => $this->params['items'],
            ),
            array(
                'class'       => 'bootstrap.widgets.TbMenu',
                'type'        => 'navbar',
                'items'       => $this->controller->yupe->getLanguageSelectorArray(),
                'htmlOptions' => array(
                    'class' => 'pull-right',
                ),
            )
        ),
    )
);

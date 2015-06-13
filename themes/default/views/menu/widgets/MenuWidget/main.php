<?php
Yii::import('application.modules.menu.components.YMenu');
$this->widget(
    'bootstrap.widgets.TbNavbar',
    [
        'collapse' => true,
        'brand' => CHtml::image(
            Yii::app()->getTheme()->getAssetsUrl() . '/images/logo.png',
            Yii::app()->name,
            [
                'width' => '38',
                'height' => '38',
                'title' => Yii::app()->name,
            ]
        ),
        'brandUrl' => Yii::app()->hasModule('homepage') ? ['/homepage/hp/index'] : ['/site/index'],
        'items' => [
            CMap::mergeArray(
                [
                    'class' => 'YMenu',
                    'type' => 'navbar',
                    'items' => $this->params['items'],
                ],
                $layoutParams
            ),
            [
                'class' => 'bootstrap.widgets.TbMenu',
                'type' => 'navbar',
                'items' => $this->controller->yupe->getLanguageSelectorArray(),
                'htmlOptions' => [
                    'class' => 'pull-right',
                ],
            ]
        ],
    ]
);

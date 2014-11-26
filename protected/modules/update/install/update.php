<?php
return [
    'module'   => [
        'class'  => 'application.modules.update.UpdateModule',
        'panelWidgets' => [
            'application.modules.update.widgets.PanelUpdateWidget' => []
        ]
    ],
    'component' => [
        'updateManager' => [
            'class' => 'application\modules\update\components\UpdateManager'
        ]
    ]
];

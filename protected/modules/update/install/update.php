<?php
return array(
    'module'   => array(
        'class'  => 'application.modules.update.UpdateModule',
        'panelWidgets' => array(
            'application.modules.update.widgets.PanelUpdateWidget' => []
        )
    ),
    'component' => array(
        'updateManager' => array(
            'class' => 'application\modules\update\components\UpdateManager'
        )
    )
);

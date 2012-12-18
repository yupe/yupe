<?php
return array(
    'module'   => array(
        'class' => 'application.modules.queue.QueueModule',
    ),
    'import'    => array(
        'application.modules.queue.components.*',
        'application.modules.queue.models.*',
    ),
    'component' => array(
        'queue' => array(
            'class'          => 'application.modules.queue.components.YDbQueue',
            'connectionId'   => 'db',
            'workerNamesMap' => array(
                1 => 'Отправка почты',
                2 => 'Ресайз изображений',
            ),
        ),
    ),
    'rules'     => array(),
);
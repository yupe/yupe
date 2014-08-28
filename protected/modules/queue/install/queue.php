<?php
return array(
    'module'    => array(
        'class'          => 'application.modules.queue.QueueModule',
        'workerNamesMap' => array(
            1 => 'Mail sending',
            2 => 'Image resizing',
        ),
    ),
    'import'    => array(
        'application.modules.queue.components.*',
        'application.modules.queue.models.*',
    ),
    'component' => array(
        'queue' => array(
            'class'        => 'application.modules.queue.components.YDbQueue',
            'connectionId' => 'db'
        ),
    ),
    'rules'     => array(),
);

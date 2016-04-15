<?php
return [
    'module'    => [
        'class'          => 'application.modules.queue.QueueModule',
        'workerNamesMap' => [
            1 => 'Mail sending',
            2 => 'Image resizing',
        ],
    ],
    'import'    => [
        'application.modules.queue.components.*',
        'application.modules.queue.models.*',
    ],
    'component' => [
        'queue' => [
            'class'        => 'application.modules.queue.components.YDbQueue',
            'connectionId' => 'db'
        ],
    ],
    'rules'     => [],
];

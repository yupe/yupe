<?php
return [
    'module' => [
        'class' => 'application.modules.notify.NotifyModule',
    ],
    'import' => [
        'application.modules.notify.listeners.*',
    ],
    'component' => [
        'notify' => [
            'class' => 'notify\components\Notify',
            'mail' => [
                'class' => 'yupe\components\Mail',
            ],
        ],
    ],
    'rules' => [
        '/profile/notify' => 'notify/notify/settings'
    ],
];

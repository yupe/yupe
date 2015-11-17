<?php
return [
    'module' => [
        'class' => 'application.modules.callback.CallbackModule',
    ],
    'import' => [],
    'component' => [
        'callbackManager' => [
            'class' => 'application.modules.callback.components.CallbackManager',
        ],
    ],
    'rules' => [
        '/callback' => '/callback/callback/send',
    ],
];

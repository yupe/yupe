<?php
return [
    'module' => [
        'class' => 'application.modules.callback.CallbackModule',
    ],
    'import' => [
        'application.modules.callback.CallbackModule',
        'application.modules.callback.listeners.CallbackTemplateListener',
    ],
    'component' => [
        'callbackManager' => [
            'class' => 'application.modules.callback.components.CallbackManager',
        ],
        'eventManager' => [
            'class' => 'yupe\components\EventManager',
            'events' => [
                'template.head.end' => [
                    ['CallbackTemplateListener', 'js'],
                ],
            ],
        ],
    ],
    'rules' => [
        '/callback' => '/callback/callback/send',
    ],
];

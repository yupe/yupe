<?php
return [
    'module'    => [
        'class' => 'application.modules.notify.NotifyModule',
    ],
    'import'    => [
        'application.modules.notify.listeners.*',
    ],
    'component' => [
        'eventManager'   => [
            'class'  => 'yupe\components\EventManager',
            'events' => [
                'user.success.activate' => [
                    ['UserActivationListener', 'onUserActivate']
                ],
                'comment.add.success' => [
                    ['NotifyNewCommentListener', 'onNewComment']
                ],
            ]
        ],
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

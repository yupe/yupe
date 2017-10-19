<?php
return [
    'module' => [
        'class' => 'application.modules.favorite.FavoriteModule',
    ],
    'import' => [
        'application.modules.favorite.components.FavoriteService',
        'application.modules.favorite.listeners.TemplateListener',
        'application.modules.favorite.events.*'
    ],
    'component' => [
        'favorite' => [
            'class' => 'application.modules.favorite.components.FavoriteService'
        ],
        'eventManager'   => [
            'class'  => 'yupe\components\EventManager',
            'events' => [
                'template.head.start' => [
                    ['TemplateListener', 'js']
                ]
            ]
        ]
    ],
    'rules' => [
        '/favorite/add' => '/favorite/default/add',
        '/favorite/remove' => '/favorite/default/remove',
        '/favorite' => '/favorite/default/index',
    ],
];

<?php

return [
    'rules' => [
        '/backend'                                                     => false,
        '/backend/login'                                               => false,
        '/backend/<action:\w+>'                                        => false,
        '/backend/<module:\w+>/<controller:\w+>'                       => false,
        '/backend/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => false,
        '/backend/<module:\w+>/<controller:\w+>/<action:\w+>'          => false,


        '/admin'                                                     => '/yupe/backend/index',
        '/admin/login'                                               => '/user/account/backendlogin',
        '/admin/<action:\w+>'                                        => '/yupe/backend/<action>',
        '/admin/<module:\w+>/<controller:\w+>'                       => '/<module>/<controller>Backend/index',
        '/admin/<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '/<module>/<controller>Backend/<action>',
        '/admin/<module:\w+>/<controller:\w+>/<action:\w+>'          => '/<module>/<controller>Backend/<action>',
    ]
];

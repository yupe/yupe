<?php
return array(
    'module'   => array(
        'class'   => 'application.modules.yeeki.YeekiModule',
        'modules' => array(
            'wiki' => array(
                'userAdapter' => array( 'class' => 'WikiUser' ),
            ),
        ),
    ),
    'import' => array(),
    'component' => array(),
    'rules'     => array(
        '/wiki/<controller:\w+>/<action:\w+>' => 'yeeki/wiki/<controller>/<action>',
    ),
);
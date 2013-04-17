<?php
return array(
    'module'   => array(
        'class'           => 'application.modules.docs.DocsModule',
    ),
    'import'    => array(
    ),
    'rules'     => array(
        '/backend/docs/<action:\w+>' => 'docs/default/<action>',
        '/docs/<file:.*>'            => 'docs/show/index',
        '/docs'                      => 'docs/show/index',
    ),
);
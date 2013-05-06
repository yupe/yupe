<?php
return array(
    'module'   => array(
        'class'           => 'application.modules.docs.DocsModule',
    ),
    'import'    => array(
    ),
    'rules'     => array(
        '/docs/<moduleID:[a-zA-Z0-9\-_.]+>/<file:[a-zA-Z0-9\-_.]+>.html' => 'docs/show/index',
        '/docs/<file:[a-zA-Z0-9\-_.]+>.html'                             => 'docs/show/index',
        '/backend/docs/<file:[a-zA-Z0-9\-_.]+>.html'                     => 'docs/default/show',
        '/backend/docs'                                                  => 'docs/default/index',
        '/backend/docs/<action:\w+>'                                     => 'docs/default/<action>',
        '/docs'                                                          => 'docs/show/index',
    ),
);
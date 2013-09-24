<?php
return array(
    'import'    => array(),
    'rules'     => array(
        '/docs/<moduleID:[a-zA-Z0-9\-_.]+>/<file:[a-zA-Z0-9\-_.]+>.html' => 'docs/show/index',
        '/docs/<file:[a-zA-Z0-9\-_.]+>.html'                             => 'docs/show/index',
        '/backend/docs/<file:[a-zA-Z0-9\-_.]+>.html'                     => 'docs/default/show',
        '/backend/docs'                                                  => 'docs/default/index',
        '/backend/docs/<action:\w+>'                                     => 'docs/default/<action>',
        '/docs'                                                          => 'docs/show/index',
    ),
    'module' => array(
        'class'           => 'application.modules.docs.DocsModule',
        'preload'         => array('bootstrap'),
        'components'      => array(
            'bootstrap'   => array(
                'class'          => 'vendor.clevertech.yii-booster.src.components.Bootstrap',
                'coreCss'        => true,
                'responsiveCss'  => true,
                'yiiCss'         => true,
                'jqueryCss'      => true,
                'enableJS'       => true,
                'fontAwesomeCss' => true,
            ),
        ),
    ),
);

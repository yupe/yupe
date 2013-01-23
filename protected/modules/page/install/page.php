<?php
return array(
    'module'   => array(
        'class'  => 'application.modules.page.PageModule',
        'layout' => 'application.views.layouts.column2',
    ),
    'import'    => array(
        'application.modules.page.models.*',
    ),
    'component' => array(),
    'rules'     => array(
        '/pages/<slug>' => 'page/default/show',
    ),
);
<?php
return array(
    'module'   => array(
        'class'  => 'application.modules.page.PageModule',
        // Указание здесь layout'a портит отображение на фронтенде:
        //'layout' => '//layouts/column2',
    ),
    'import'    => array(
        'application.modules.page.models.*',
    ),
    'component' => array(),
    'rules'     => array(
        '/pages/<slug>' => 'page/page/show',
    ),
);
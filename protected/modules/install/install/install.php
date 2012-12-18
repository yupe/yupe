<?php
return array(
    'module'   => array(
        'class' => 'application.modules.install.InstallModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '/install' => 'install/default/index',
    ),
);
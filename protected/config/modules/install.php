<?php
return array(
    'module'   => array(
        'class' => 'application.modules.install.InstallModule',
    ),
    'import'    => array(),
    'component' => array(),
    'rules'     => array(
        '*'                                            => 'install/default/index',
        '/<action>'                                    => 'install/default/index',
        '/<controller>/<action>'                       => 'install/default/index',
        '/<module:[^install].*>/<controller>/<action>' => 'install/default/index',
    ),
);
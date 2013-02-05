<?php
return array(
    'install' => true,
    'rules'   => array(
        // правила контроллера site
        '/'             =>'site/index',
        '/<view:\w+>'   => 'site/page',
    ),
);
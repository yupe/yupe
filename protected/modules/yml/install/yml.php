<?php

return [
    'module' => [
        'class' => 'application.modules.yml.YmlModule',
    ],
    'rules' => [
        '/yml/export/<id:\d+>' => 'yml/export/view',
    ],
];

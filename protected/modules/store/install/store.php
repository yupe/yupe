<?php

return array(
    'module' => array(
        'class' => 'application.modules.store.StoreModule',
    ),
    'import' => array(
        'application.modules.store.models.*',
    ),
    'component' => array(
        'money' => array(
            'class' => 'application.modules.store.components.Money',
        ),
    ),
    'rules' => array(
        '/catalog' => 'store/catalog/index',
        '/catalog/search' => 'store/catalog/search',
        '/catalog/show/<name:[\w_\/-]+>' => 'store/catalog/show',
        '/catalog/<path:[\w_\/-]+>' => 'store/catalog/category',
        '/store/catalog/autocomplete' => 'store/catalog/autocomplete'
    ),
);

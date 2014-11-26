<?php

/**
 * Файл настроек модуля
 *
 * @category YupeController
 * @package  yupe.modules.docs.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @version  0.1
 * @link     http://yupe.ru
 *
 **/

return [
    'import' => [],
    'rules'  => [
        '/docs/<moduleID:[a-zA-Z0-9\-_.]+>/<file:[a-zA-Z0-9\-_.]+>.html' => 'docs/show/index',
        '/docs/<file:[a-zA-Z0-9\-_.]+>.html'                             => 'docs/show/index',
        '/backend/docs/<file:[a-zA-Z0-9\-_.]+>.html'                     => 'docs/docsBackend/show',
        '/docs'                                                          => 'docs/show/index',
    ],
    'module' => [
        'class' => 'application.modules.docs.DocsModule',
    ],
];

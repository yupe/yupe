<?php
/**
 * Файл конфигурации модуля
 *
 * @category YupeController
 * @package  yupe.modules.feedback.install
 * @author   YupeTeam <team@yupe.ru>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link     http://yupe.ru
 *
 **/
return [
    'module'    => [
        'class'           => 'application.modules.feedback.FeedbackModule',
        'notifyEmailFrom' => 'test@test.ru',
        'emails'          => 'test_1@test.ru, test_2@test.ru',
        'panelWidgets'    => [
            'application.modules.feedback.widgets.PanelFeedbackStatWidget' => [
                'limit' => 5
            ]
        ]
    ],
    'import'    => [
        'application.modules.yupe.YupeModule'
    ],
    'component' => [],
    'rules'     => [
        '/contacts'                             => '/feedback/contact/index',
        '/faq'                                  => '/feedback/contact/faq',
        '/faq/<id:\d+>'                         => '/feedback/contact/faqView',
        '/feedback/contact/captcha/refresh/<v>' => '/feedback/contact/captcha/refresh',
        '/feedback/contact/captcha/<v>'         => '/feedback/contact/captcha/'
    ],
];

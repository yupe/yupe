<?php
return array(
    'module'   => array(
        'class'           => 'application.modules.feedback.FeedbackModule',
        'notifyEmailFrom' => 'test@test.ru',
        'emails'          => 'test_1@test.ru, test_2@test.ru',
    ),
    'import'    => array(
        'application.modules.feedback.models.*',
    ),
    'component' => array(),
    'rules'     => array(
        '/contacts' => 'feedback/contact/index',
        '/faq' => 'feedback/contact/faq',
        '/faq/<id:\d+>' => 'feedback/contact/faqView',
    ),
);
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
        '/feedback'              => 'feedback/contact/index',
        '/feedback/<action:\w+>' => 'feedback/contact/<action>',
    ),
);
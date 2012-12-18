<?php
return array(
    'module'    => array(
        'class' => 'application.modules.mail.MailModule',
    ),
    'import'    => array(),
    'component' => array(
        // компонент для отправки почты
        'mail' => array(
            'class' => 'application.modules.mail.components.YMail',
        ),
        'mailMessage' => array(
            'class' => 'application.modules.mail.components.YMailMessage'
        ),
    ),
    'rules'     => array(),
);
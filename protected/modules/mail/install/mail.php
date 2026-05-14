<?php

/**
 *
 * Файл конфигурации модуля
 *
 * @category YupeMigration
 * @package  yupe.modules.install
 * @author   YupeTeam <support@yupe.ru>
 * @license  BSD https://raw.github.com/yupe/yupe/master/LICENSE
 * @link     https://yupe.ru
 **/

return [
    'module'    => [
        'class' => 'application.modules.mail.MailModule',
    ],
    'import'    => [],
    'component' => [
        // компонент для отправки почты
        'mail'        => [
            'class' => 'yupe\components\Mail',
        ],
        'mailMessage' => [
            'class' => 'application.modules.mail.components.YMailMessage'
        ],
    ],
    'rules'     => [],
];

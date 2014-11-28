<?php

/**
 * @author Zmiulan <info@yohanga.biz>
 * @link http://yohanga.biz
 * @copyright 2014 Zmiulan
 *
 */

return [
    'module'    => [
        'class' => 'application.modules.sms.SmsModule',
    ],
    'import'    => [
        'application.modules.sms.SmsModule',
        'application.modules.sms.models.*',
        'application.modules.sms.forms.*',
        'application.modules.sms.components.*',
    ],
    'component' => [
        // компонент для отправки смс
        'smsru' => [
            'class' => 'application.modules.sms.components.smsru.Smsru',
        ],
        'notify'  => [
            'behaviors' => [
                'smsBehavior' => [
                    'class' => 'application.modules.sms.behaviors.NotifyBehavior',
                ],
            ],
        ],
        'userManager'           => [
            'behaviors' => [
                'smsBehavior' => [
                    'class' => 'application.modules.sms.behaviors.UserManagerBehavior',
                ],
            ],
        ],
        'eventManager'          => [
            'events' => [
                'user.success.phone.confirm'     => [
                    ['SmsListener', 'onSuccessPhoneConfirm']
                ],
                'user.success.phone.change'     => [
                    ['SmsListener', 'onSuccessPhoneChange']
                ]
            ]
        ]
    ],
    'rules'     => [
        '/profile/phone'                    => 'sms/account/profilePhone',
        '/profile/phoneConfirm'             => 'sms/account/confirmPhone',
    ],
];

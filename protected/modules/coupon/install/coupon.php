<?php

return [
    'module' => [
        'class' => 'application.modules.coupon.CouponModule',
    ],
    'import' => [
        'application.modules.coupon.models.*',
        'application.modules.coupon.helpers.*',
    ],
    'component' => [
        'couponManager' => [
            'class' => 'application.modules.coupon.components.CouponManager',
        ],
    ],
    'rules' => [
        '/coupon/<action:\w+>' => 'coupon/coupon/<action>',
        '/coupon/<action:\w+>/<id:\w+>' => 'coupon/coupon/<action>',
    ],
];

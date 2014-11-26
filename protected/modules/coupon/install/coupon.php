<?php

return [
    'module' => [
        'class' => 'application.modules.coupon.CouponModule',
    ],
    'import' => [
        'application.modules.coupon.models.*'
    ],
    'rules' => [
        '/coupon/<action:\w+>' => 'coupon/coupon/<action>',
        '/coupon/<action:\w+>/<id:\w+>' => 'coupon/coupon/<action>',
    ],
];

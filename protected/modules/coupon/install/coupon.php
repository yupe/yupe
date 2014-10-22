<?php

return array(
    'module' => array(
        'class' => 'application.modules.coupon.CouponModule',
    ),
    'import' => array(
        'application.modules.coupon.models.*'
    ),
    'rules' => array(
        '/coupon/<action:\w+>' => 'coupon/coupon/<action>',
        '/coupon/<action:\w+>/<id:\w+>' => 'coupon/coupon/<action>',
    ),
);

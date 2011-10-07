<?php

return array(
    'sample1' => array(
        'creation_date' => new CDbExpression('NOW()'),
        'nick_name' => 'xoma',
        'email' => 'xoma@mail.ru',
        'salt' => '1234546',
        'password' => md5(1234546),
        'code' => md5(1234546),
    ),
    'sample2' => array(
        'creation_date' => new CDbExpression('NOW()'),
        'nick_name' => 'xoma2',
        'email' => 'xoma2@mail.ru',
        'salt' => '1234546',
        'password' => md5(1234546),
        'code' => md5(12345462),
    ),

);

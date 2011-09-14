<?php

return array(
    'sample1' => array(
        'creationDate' => new CDbExpression('NOW()'),
        'nickName' => 'xoma',
        'email' => 'xoma@mail.ru',
        'salt' => '1234546',
        'password' => md5(1234546),
        'code' => md5(1234546),
    ),
    'sample2' => array(
        'creationDate' => new CDbExpression('NOW()'),
        'nickName' => 'xoma2',
        'email' => 'xoma2@mail.ru',
        'salt' => '1234546',
        'password' => md5(1234546),
        'code' => md5(12345462),
    ),

);

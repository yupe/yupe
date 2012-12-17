<?php
return array(
    // подключение библиотеки для авторизации через социальные сервисы, подробнее: https://github.com/Nodge/yii-eauth
    'loid' => array(
        'class' => 'application.modules.social.extensions.lightopenid.loid',
    ),
    'queue' => array(
        'class'          => 'application.modules.queue.components.YDbQueue',
        'connectionId'   => 'db',
        'workerNamesMap' => array(
            1 => 'Отправка почты',
            2 => 'Ресайз изображений',
        ),
    ),
    // экстеншн для авторизации через социальные сети подробнее: http://habrahabr.ru/post/129804/
    'eauth' => array(
        'class'    => 'application.modules.social.extensions.eauth.EAuth',
        'popup'    => true,  // use the popup window instead of redirecting.
        'services' => array( // you can change the providers and their classes.
            'google' => array('class' => 'CustomGoogleService'),
            'yandex' => array('class' => 'CustomYandexService'),
        ),
    ),
    // компонент для отправки почты
    'mail' => array(
        'class' => 'application.modules.mail.components.YMail',
    ),
    'mailMessage' => array(
        'class' => 'application.modules.mail.components.YMailMessage'
    ),
    // компонент Yii::app()->user, подробнее http://www.yiiframework.ru/doc/guide/ru/topics.auth
    'user' => array(
        'class'    => 'application.modules.user.components.YWebUser',
        'loginUrl' => '/user/account/login/',
    ),
    
/*
        // Если используется модуль geo  - надо как-то интегрировать в сам модуль
        'sxgeo' => array(
            'class' => 'application.modules.geo.extensions.sxgeo.CSxGeoIP',
            'filename' => dirname(__FILE__)."/../modules/geo/data/SxGeoCity.dat",
        ),
*/
);
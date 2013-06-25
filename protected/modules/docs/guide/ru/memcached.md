# Конфигурация Memcahed #

**Автор**: [Комманда разработчиков Юпи!](http://yupe.ru/feedback/index?from=docs)

**Версия**: 0.1 (dev)

**Авторское право**:  2009-2013 Yupe!

**Лицензия**: [BSD](https://github.com/yupe/yupe/blob/master/LICENSE)

## Настройка "userspace" файла конфигурации ##

Для работы с memcached вам потребуется настроить конфигурацию, для этого достаточно добавить файл
`yupe.php` в каталог `./protected/config/userspace/`


Пример реализации конфиграции:

~~~
[php]
<?php
return array(
    'cache'              => array(
        'class'          => 'system.caching.CMemCache',
        'useMemcached'   => true,
        'servers'        => array(
            array('host' =>'127.0.0.1', 'port'=>11211),
            ...
        ),
        'behaviors'      => array(
            'clear'      => array(
                'class'  => 'application.modules.yupe.extensions.tagcache.TaggingCacheBehavior',
            ),
        ),
    ),
);
~~~
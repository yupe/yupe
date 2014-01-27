# Конфигурация Memcahed #

## Настройка кеширования через "userspace" и файл конфигурации ##

По умолчанию Юпи! использует кеширование в файлы и стандартный Yii компонент CFileCache.

Для работы с memcached вам потребуется настроить переопределить настройки компонента кэша, для этого достаточно добавить файл
`yupe.php` в каталог `./protected/config/userspace/`


Пример конфиграции:

<pre><code class="php">
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
</code></pre>

Подробнее про использование userspace для конфигурирования проекта читайте [здесь](http://yupe.ru/docs/yupe/userspace.config.html).


**При возникновении проблем - [напишите нам](http://amylabs.ru/contact)!**
yii2-debug
==========

Отладочная панель для Yii 1.1 портированная из Yii 2.

[![Total Downloads](https://poser.pugx.org/zhuravljov/yii2-debug/downloads.png)](https://packagist.org/packages/zhuravljov/yii2-debug)

Использование
-------------

Необходимо скопировать исходники в `/protected/extensions` и дополнить конфиг
своего проекта следующими настройками:

```php
return array(
    'preload' => array(
        'debug',
    ),
    'components' => array(
        'debug' => array(
            'class' => 'ext.yii2-debug.Yii2Debug',
        ),
        'db' => array(
            'enableProfiling' => true,
            'enableParamLogging' => true,
        ),
    ),
);
```

Настройка
---------

Для более тонкой настройки компонента доступны параметры:

- `enabled` - включение/выключение дебаггера.
- `allowedIPs` - список ip и масок, которым разрешен доступ к панели. По умолчанию `array('127.0.0.1', '::1')`.
- `accessExpression` - дополнительное условие доступа к панели.
- `logPath` - путь для записи логов. По умолчанию `/runtime/debug`.
- `historySize` - максимальное кол-во записанных логов. Более ранние логи будут удаляться.
- `highlightCode` - подсветка кода. Подсвечиваются sql-запросы и php-массивы данных. Также параметр `highlightCode` можно настраивать для каждой панели отдельно.
- `moduleId ` - ID модуля для просмотра ранее сохраненных данных. По умолчанию `debug`.
- `internalUrls` - использование внутренних роутов для urlManager
- `panels` - список подключенных к отладчику панелей.

Каждую подключаемую к отладчику панель так-же можно конфигурировать. Например:

```php
'debug' => array(
    'class' => 'ext.yii2-debug.Yii2Debug',
    'panels' => array(
        'db' => array(
            // Отключить подсветку SQL
            'highlightCode' => false,
            // Отключить подстановку параметров в SQL-запрос
            'insertParamValues' => false,
        ),
    ),
),
```

Для каждой панели доступен callback-параметр `filterData`. Он дает возможность
обработать массив данных перед сохранением этих данных в лог. Это может быть
полезно в том случае, когда в данных проходит какая-то секретная информация, и
ее нужно каким-то образом экранировать либо вообще изъять из массива.

Пример:

```php
'debug' => array(
    'class' => 'ext.yii2-debug.Yii2Debug',
    'panels' => array(
        'db' => array(
            'filterData' => function($data){
                // Обработка
                return $data;
            }
        ),
    ),
),
```

Будьте осторожны с изменением структуры данных. Это может стать причиной ошибок
при просмотре.

Подключение собственных панелей
-------------------------------

Необходимо разработать свой класс унаследовав его от `Yii2DebugPanel`, например:

```php
class MyTestPanel extends Yii2DebugPanel
{
    // Имя вашей панели, выводится в меню отладчика
    public function getName()
    {
        return 'Name';
    }

    // Функция должна возвращать HTML для вывода в тулбар
    // Данные доступны через свойство $this->data
    public function getSummary()
    {
        return '';
    }

    // Функция должна вернуть HTML с детальной информацией
    // Данные доступны через свойство $this->data
    public function getDetail()
    {
        return '';
    }

    // Функция должна вернуть массив данных для сохранения в лог
    public function save()
    {
        return array();
    }
}
```

И подключить его в конфиг:

```php
'panels' => array(
    'test' => array(
        'class' => 'path.to.panel.MyTestPanel',
        // ...
    ),
),
```

Различные приёмы
----------------

### Status Code

Если в вашем проекте используется PHP < 5.4, то для записи http-кода в логи и
вывода его на панель можно воспользоваться следующей настройкой:

```php
'panels' => array(
    'request' => array(
        'filterData' => function($data){
            if (empty($data['statusCode'])) {
                if (isset($data['responseHeaders']['Location'])) {
                    $data['statusCode'] = 302;
                } else {
                    $data['statusCode'] = 200;
                }
            }
            return $data;
        },
    ),
),
```

Таким образом 302-й код определяется косвенно, исходя из наличия заголовка `Location`.
Коды 4xx и 5xx определяются расширением самостоятельно. В PHP 5.4 для определения
http-кода расширение использует встроенную функцию `http_response_code()`.
# Curl обёртка для Yii framework #

**Автор**: [Комманда разработчиков Юпи!](http://yupe.ru/feedback/contact?from=docs)

**Версия**: 0.1 (dev)

**Авторское право**:  2009-2013 Yupe!

**Лицензия**: [BSD](https://github.com/yupe/yupe/blob/master/LICENSE)

## Требования ##
* PHP 5.3+
* Yii 1.1.7 (также работает на версиях выше)
* Curl и php-curl установленные расширения

## Настройка инструментария ##

*Необходимо лишь тогда, когда вы используете его отдельно от Юпи.*

* Добавляем Curl.php в необходимый каталог вашего проекта, например protected/extensions
* в main.php, добавляем следующее в раздел 'components':


~~~
[php]
    'curl' => array(
            'class' => 'ext.Curl',
            'options' => array(/.. особые настройки curl ../)
        );
~~~


## Использование
* для обращения методом GET к странице с настройками поумолчанию

~~~
[php]
$output = Yii::app()->curl->get($url, $params);
// в переменной $output будет результат выполнения запроса (контент)
// $params - параметры для данного запроса
~~~


* для обращения методом POST к странице

~~~
[php]
$output = Yii::app()->curl->post($url, $data);
// $data - данные, которые будут переданы в запросе
~~~

* для настройки параметров CURL до выполнения GET или POST

~~~
[php]
$output = Yii::app()->curl->setOption($name, $value)->get($url, $params);
// $name & $value - CURL опции
$output = Yii::app()->curl->setOptions(array($name => $value))->get($get, $params);
// иначе, можно использовать ключ => значение для настройки
~~~
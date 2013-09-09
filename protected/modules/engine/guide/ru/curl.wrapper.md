# Обёртка для Curl #

## Требования ##
* PHP 5.3+
* Yii 1.1.7 (также работает на версиях выше)
* Curl и php-curl установленные расширения

## Настройка инструментария ##

*Необходимо лишь тогда, когда вы используете его отдельно от Юпи!*

* Добавляем Curl.php в необходимый каталог вашего проекта, например protected/extensions
* в main.php, добавляем следующее в раздел 'components':


<pre><code class="php">
    'curl' => array(
            'class' => 'ext.Curl',
            'options' => array(/.. особые настройки curl ../)
        );

</code></pre>


## Использование
* для обращения методом GET к странице с настройками поумолчанию

<pre><code class="php">
$output = Yii::app()->curl->get($url, $params);
// в переменной $output будет результат выполнения запроса (контент)
// $params - параметры для данного запроса

</code></pre>


* для обращения методом POST к странице

<pre><code class="php">
$output = Yii::app()->curl->post($url, $data);
// $data - данные, которые будут переданы в запросе

</code></pre>

* для настройки параметров CURL до выполнения GET или POST

<pre><code class="php">
$output = Yii::app()->curl->setOption($name, $value)->get($url, $params);
// $name & $value - CURL опции
$output = Yii::app()->curl->setOptions(array($name => $value))->get($get, $params);
// иначе, можно использовать ключ => значение для настройки
</code></pre>
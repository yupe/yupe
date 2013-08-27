# Curl Wrapper for Yii framework

## Requirements
* PHP 5.3+
* Yii 1.1.7 (should work on older versions too)
* Curl and php-curl installed

## Setup instructions

*Only if you don't use Yupe*

* Place Curl.php into protected/extensions folder of your project
* in main.php, add the following to 'components':


<pre><code class="php">
    'curl' => array(
            'class' => 'ext.Curl',
            'options' => array(/.. additional curl options ../)
        );

</code></pre>


## Usage
* to GET a page with default params

<pre><code class="php">
    $output = Yii::app()->curl->get($url, $params);
    // output will contain the result of the query
    // $params - query that'll be appended to the url

</code></pre>


* to POST data to a page

<pre><code class="php">
    $output = Yii::app()->curl->post($url, $data);
    // $data - data that will be POSTed

</code></pre>

* to set options before GET or POST

<pre><code class="php">
    $output = Yii::app()->curl->setOption($name, $value)->get($url, $params);
    // $name & $value - CURL options
    $output = Yii::app()->curl->setOptions(array($name => $value))->get($get, $params);
    // pass key value pairs containing the CURL options

</code></pre>
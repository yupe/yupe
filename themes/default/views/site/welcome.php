<h1>Поздравляем!</h1>
<p>Вы только что установили <a href="http://yupe.ru?from=mainpage">Юпи CMS</a> на свой сервер.
Обязательно измените параметр <code>"csrfTokenName"</code>. Это можно сделать в файле - <code>./protected/config/main.php</code>.
Строка имеет вид:</p>
<?php
$highlighter = new CTextHighlighter;
$highlighter->language = 'PHP';
echo $highlighter->highlight(
    "
    'request' => array(
    'class'                  => 'YHttpRequest',
    'enableCsrfValidation'   => true,
    'csrfTokenName'          => 'YUPE_TOKEN',
    "
); ?>
<p> И не забывайте выключать DEBUG-режим (<code>YII_DEBUG</code>).</p>
<p> После данных процедур ваш очередной сайт на <a href='http://yupe.ru/?from=mainpage'>Юпи!</a> готов к работе!</p>
<p> Для управления сайтом, пожалуйста, перейдите в <?php echo CHtml::link('панель управления', array('/yupe/backend/')); ?>.</p>
<p> При возникновении вопросов или проблем - обращайтесь на наш <a href='http://yupe.ru/talk/?from=mainpage'>форум</a> или пишите об ошибках на <a href='https://github.com/yupe/yupe/issues'>Github</a>.</p>
<p>Также вы можете читать нас в <a href='http://twitter.com/yupecms'>twitter</a> или <a href='http://vk.com/yupeko'>Вконтакте</a></p>
<p><a href='http://yupe.ru/site/page/view/help/?from=mainpage'>Желаете помочь проекту ?</a></p>

<p><b>По вопросам коммерческой поддержки - <a href='http://yupe.ru/feedback/index/?from=mainpage'>напишите нам</a>!</b></p>

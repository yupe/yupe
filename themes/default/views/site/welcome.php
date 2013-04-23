<h1>Поздравляем!</h1>
<p>Вы только что установили <a href="http://yupe.ru?from=mainpage">Юпи! CMS</a>.</p>
<p>Обязательно измените параметр <code>"csrfTokenName"</code>. Это можно сделать в файле - <code>./protected/config/main.php</code>.</p>
Строка имеет вид:
<?php
$highlighter = new CTextHighlighter;
$highlighter->language = 'PHP';
echo $highlighter->highlight(
    "
    'request' => array(
        'class'                  => 'YHttpRequest',
        'enableCsrfValidation'   => true,
        'csrfTokenName'          => 'YUPE_TOKEN',
    )
    "
); ?>
<p> Начните доработку Вашего сайта с правки SiteController (/protected/controller/SiteController).</p>
<p> И не забывайте выключать DEBUG-режим (<code>YII_DEBUG</code>).</p>

<p> После данных процедур ваш сайт на <a href='http://yupe.ru/?from=mainpage'>Юпи!</a> будет готов к работе!</p>
<p> Для управления сайтом, пожалуйста, перейдите в <?php echo CHtml::link('панель управления', array('/yupe/backend/')); ?>.</p>
<p> При возникновении вопросов или проблем - обращайтесь на наш <a href='http://yupe.ru/talk/?from=mainpage'>форум</a> или сообщите об ошибках на <a href='https://github.com/yupe/yupe/issues'>Github</a>.</p>
<p> Читайте нас в <a href='http://twitter.com/yupecms'>twitter</a> или <a href='http://vk.com/amylabs'>Вконтакте</a></p>
<p> Посетите раздел с <a href='http://yupe.ru/docs/index.html'> официальной документацией </a></p>
<p><a href='http://yupe.ru/pages/help?from=mainpage'>Желаете помочь проекту ?</a></p>

<p><b>По вопросам коммерческой поддержки - <a href='http://yupe.ru/feedback/index/?from=mainpage'>напишите нам</a> !</b></p>

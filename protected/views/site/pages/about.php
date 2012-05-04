<?php $this->pageTitle = 'Юпи! | О проекте'; ?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?> - мини цмс на Yii!</h1>

<b>!!!ВНИМАНИЕ!!! <br/><br/> Юпи! пока не готов для "промышленного"
    использования, но мы делаем все для этого! Поддержите нас!</b>
<br/><br/>

<p><b>Юпи!</b> - блого-социальный движок (мини CMS) на замечательном фреймворке <a
    href="http://yiiframework.ru">Yii</a> !</p>

<p><b>Юпи!</b> можно использовать и для создания простых сайтов!</p>

<p>Хотите создать сайт-визитку со всеми "плюшками" Yii !? Нет проблем! </p>

<p>Хотите создать блоговое сообщество !? И это возможно! </p>

<p>Используя <b>Юпи!</b>, Вы сможете развернуть сайт или блог, работающий на
    фреймворке <b>Yii</b> всего за 5 минут !
</p>

<p>Основные возможности:</p>

<ul>
    <li>Управление пользователями (регистрация и авторизация, в том числе и через соц. сети)</li>
    <li>Персональные и коллективные блоги (хотите свой хабрахабр на Yii ?)</li>
    <li>Управления разделами/категориями (пока в самом простом виде)</li>
    <li>Создание "статических" страниц ("О нас", "О проекте" и т.д. - такие странички создаются очень легко =))</li>
    <li>Добавление и публикация новостей (современный сайт без новостей существовать не может)</li>
    <li>Обратная связь с пользователем (вдруг кто-то что-то Вам захочет написать)</li>
    <li>Комментарии (комментируйте что угодно, модуль очень гибкий)</li>
</ul>

<p><b>Юпи!</b> - это <b>НЕ</b> универсальный конструктор сайтов типа Drupal или
    Joomla.</p>

<p> Вы просто берете готовый  функционал и используете его!</p>

<p>Если возникает необходимость добавить какие-то специфичные возможности - <a
    href="http://www.yiiframework.ru/forum/viewforum.php?f=11&sid=09889fba4daf3bce2daa575e4ec9cec8">находите
    Yii-разрабочика</a> и получаете то, что хотите ..или <?php echo CHtml::link('напишите нам', array('/feedback/contact/'));?>
    =)</p>

<p>Хотите получить самую последнюю версию, сообщить об ошибке или просмотреть
    исходный код - посетите <a
        href='https://github.com/yupe/yupe/'>https://github.com/yupe/yupe</a>
</p>

<p>Возможно, Вы хотите присоединиться к разработке
    !? <?php echo CHtml::link('Напишите нам', array('/feedback/contact/'));?>
    !</p>

<p>Наш твиттер - <a href="https://twitter.com/#!/YupeCms">https://twitter.com/#!/YupeCms</a></p>


<p>
    Желающим помочь проекту рекомендую
    посетить <?php echo CHtml::link('эту страничку', array('/site/page/', 'view' => 'help'));?> или сразу 
    <iframe width="200" scrolling="no" height="42" frameborder="0"
            src="https://money.yandex.ru/embed/small.xml?uid=41001846363811&button-text=05&button-size=m&button-color=orange&targets=%d0%9d%d0%b0+%d1%80%d0%b0%d0%b7%d0%b2%d0%b8%d1%82%d0%b8%d0%b5+%d0%ae%d0%bf%d0%b8!&default-sum=50&fio=on&mail=on"
            allowtransparency="true" style="vertical-align: middle;"></p>

<div style="float:left">
    <div style="float:left;padding-right:5px">
        <?php
            $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                'type' => 'button',
                'services' => 'all'
            ));
        ?>
    </div>
</div>
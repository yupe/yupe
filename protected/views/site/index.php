<?php $this->pageTitle = Yii::app()->name; ?>

<h1><i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Юпи! - блого-социальный движок на фреймворке <a
    href='http://yiiframework.ru'>Yii</a> !</p>

<p>Юпи! можно использовать и для создания "сайтов-визиток" - сделать это очень
    просто!</p>

<p>Используя Юпи! Вы сможете развернуть сайт или блог, работающий на фреймворке
    <b>Yii</b> всего за 5 минут!</p>

<p>Основные возможности:</p>

<ul>
    <li>Управление пользователями</li>
    <li>Управления разделами/категориями</li>
    <li>Создание "статических" страниц для Вашего сайта</li>
    <li>Добавление и публикация новостей</li>
    <li>Обратная связь с пользователем</li>
</ul>

<p>Юпи! - это <b>НЕ</b> универсальный конструктор сайтов, типа Drupal или
    Joomla, Вы просто берете готовый функционал и
    используете его!</p>

<p>Если возникает необходимость добавить какие-то специфичные возможности - <a
    href='http://www.yiiframework.ru/forum/viewforum.php?f=11&sid=09889fba4daf3bce2daa575e4ec9cec8'>находите
    Yii-разрабочика</a> и получаете то, что хотите!</p>

<p>...или <?php echo CHtml::link('напишите нам', array('/feedback/contact/'));?>
    =)</p>

<p>Хотите получить самую последнюю версию, сообщить об ошибке или просмотреть
    исходный код - посетите <a
        href='https://github.com/yupe/yupe'>https://github.com/yupe/yupe</a></p>

<p>Возможно, Вы хотите присоединиться к разработке
    !? <?php echo CHtml::link('Напишите нам', array('/feedback/contact/'));?></p>

<div style='float:left;'>
    <div style='float:left;padding-right:5px'>
        <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                                  'type' => 'button',
                                                                                                  'services' => 'all'
                                                                                             ));?>
    </div>
</div>
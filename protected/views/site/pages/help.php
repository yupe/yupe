<?php $this->pageTitle = 'Юпи! | Помощь проекту'; ?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?> Помощь проекту!</h1>

<p>Если у Вас есть желание помочь развитию проекта, вот список того, что Вы
    можете сделать:</p>

<p>- <?php echo CHtml::link('Сообщить', array('/feedback/contact/'));?> о
    найденной ошибке (или на <a
        href="https://github.com/yupe/yupe/issues">github</a>)</p>

<p>- <?php echo CHtml::link('Закажите', array('/feedback/contact/'));?> у нас
    разработку сайта на <b>Yii</b> И 25% от
    суммы работ пойдет на развитие <b>Юпи!</b></p>

<p>- Нам очень сильно не хватает яркого и интересного дизайна для сайта =)</p>

<p>- <a href="https://github.com/yupe/yupe">В исходном коде</a> многие места
    помечены маркером "@TODO" - можно эти
    "тудушки" закрывать и присылать патчи (а вообще можно присылать комментарии
    и патчи на любые участки <a
        href="https://github.com/yupe/yupe">кода</a>)</p>

<p>- Всегда можно поддержать нас
    морально, <?php echo CHtml::link('написав письмо', array('/feedback/contact/'));?>
    или
    материально, отправив денежку</p>

<iframe frameborder="0" allowtransparency="true" scrolling="no"
        src="https://money.yandex.ru/embed/donate.xml?uid=41001846363811&amp;default-sum=100&amp;targets=%d0%a0%d0%b0%d0%b7%d0%b2%d0%b8%d1%82%d0%b8%d0%b5&amp;target-visibility=on&amp;project-name=%d0%ae%d0%bf%d0%b8!+-+%d0%bc%d0%b8%d0%bd%d0%b8+cms+%d0%bd%d0%b0+yii&amp;project-site=http%3a%2f%2fyupe.ru&amp;button-text=01&amp;comment=on&amp;hint=&amp;fio=on"
        width="450" height="191"></iframe>

</br></br></br>

<div style="float:left">
    <div style="float:left;padding-right:5px">
        <?php
            $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
              'type' => 'button',
              'services' => 'all',
            ));
        ?>
    </div>
</div>
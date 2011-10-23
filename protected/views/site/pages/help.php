<?php $this->pageTitle = 'Юпи! | Помощь проекту'; ?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?> Помощь проекту!</h1>

<p>Если у Вас есть желание помочь развитию проекта, вот список того, что Вы
    можете сделать:</p>


<p>- <?php echo CHtml::link('Сообщить', array('/feedback/contact/'));?> о
    найденной ошибке (или на <a
        href='https://github.com/yupe/yupe/issues'>github</a>)</p>

<p>- <?php echo CHtml::link('Закажите', array('/feedback/contact/'));?> у нас
    разработку сайта на <b>Yii</b> И 25% от
    суммы работ пойдет на развитие <b>Юпи!</b></p>

<p>- Нам очень сильно не хватает яркого и интересного дизайна для сайта =)</p>

<p>- <a href='https://github.com/yupe/yupe'>В исходном коде</a> многие места
    помечены маркером "@TODO" - можно эти
    "тудушки" закрывать и присылать патчи (а вообще можно присылать комментарии
    и патчи на любые участки <a
        href='https://github.com/yupe/yupe'>кода</a>)</p>

<p>- Всегда можно поддержать нас
    морально, <?php echo CHtml::link('написав письмо', array('/feedback/contact/'));?>
    или
    материально, отправив денежку вот на этот ЯД <b>41001846363811</b></p>


<div style='float:left;'>
    <div style='float:left;padding-right:5px'>
        <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                                  'type' => 'button',
                                                                                                  'services' => 'all'
                                                                                             ));?>
    </div>
</div>
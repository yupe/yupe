<?php
$this->pageTitle = 'Юпи! | Помощь проекту';
$this->breadcrumbs = array('Помощь проекту');
?>

<h1><?php echo CHtml::encode(Yii::app()->name); ?> Помощь проекту!</h1>

<p>Если у Вас есть желание помочь развитию проекта, вот список того, что Вы
    можете сделать:</p>

<p>- <?php echo CHtml::link('Сообщить', 'http://yupe.ru/feedback/contact/?from=helppage');?> о
    найденной ошибке (или на <a
        href="https://github.com/yupe/yupe/issues">github</a>)</p>


<p>- <b>Возможно, Вы хотите присоединиться к разработке
    !? <?php echo CHtml::link('Напишите нам', 'http://yupe.ru/feedback/contact/?from=helppage');?>
    !</b></p>

<p>- Нам очень сильно не хватает яркого и интересного дизайна для сайта =)</p>

<p>- <a href="https://github.com/yupe/yupe">В исходном коде</a> многие места
    помечены маркером "@TODO" - можно эти
    "тудушки" закрывать и присылать патчи (а вообще можно присылать комментарии
    и патчи на любые участки <a
        href="https://github.com/yupe/yupe">кода</a>)</p>

<p>- <?php echo CHtml::link('Закажите', 'http://yupe.ru/feedback/contact/?from=helppage');?> у нас
    <a href='http://yupe.ru/feedback/contact/?from=helppage'>разработку сайта</a> на <b>Yii</b> И 25% от
    суммы работ пойдет на развитие <b>Юпи!</b></p>


<p>- Всегда можно поддержать нас
    морально, <?php echo CHtml::link('написав письмо', 'http://yupe.ru/feedback/contact/?from=helppage');?>
    или
    материально, отправив денежку</p>

<p>- Если у вас есть блог или сайт - разместите наши баннеры <br/><br/>

<textarea rows="5" cols="50"><a href='http://yupe.ru?from=banner' title='Юпи! - ЦМС на Yiiframework!'><img src='http://yupe.ru/web/images/banners/468yupe.jpg' title='Юпи! - ЦМС на Yiiframework!' alt='Юпи! - ЦМС на Yiiframework!'></a></textarea>   <br/><br/>

    <a href='http://yupe.ru?from=banner' title='Юпи! - ЦМС на Yiiframework!'><img src='http://yupe.ru/web/images/banners/468yupe.jpg' title='Юпи! - ЦМС на Yiiframework!' alt='Юпи! - ЦМС на Yiiframework!'></a>
<br/><br/>
    <textarea rows="5" cols="50"><a href='http://yupe.ru?from=banner' title='Юпи! - ЦМС на Yiiframework!'><img src='http://yupe.ru/web/images/banners/125yupe.jpg' title='Юпи! - ЦМС на Yiiframework!' alt='Юпи! - ЦМС на Yiiframework!'></a></textarea>   <br/><br/>
    <a href='http://yupe.ru?from=banner' title='Юпи! - ЦМС на Yiiframework!'><img src='http://yupe.ru/web/images/banners/125yupe.jpg' title='Юпи! - ЦМС на Yiiframework!' alt='Юпи! - ЦМС на Yiiframework!'></a>
</p> 

<p>- Или перечислите нам денежку =) </p>   

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
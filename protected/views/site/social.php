<?php $this->pageTitle = 'Социальные виджеты Юпи! или Yii Social Components!'; ?>

<h1>Социальные виджеты Юпи! или Yii Social Components!</h1>

<p>Социальные виджеты предназначены для публикации Вашего контента в различных
    социальных сетях.</p>
<p>Социальные виджеты выделены в отдельный пакет и могут быть использованы в
    любом другом Yii-проекте.</p>
<p>Мы не стали размещать здесь все доступные виджеты, оставили только <a
    href='http://api.yandex.ru/share/'>Яндекс Share
    API</a> =)</p>

<p>
<p><a href='https://github.com/yupe/xomaprojects/tree/master/yii/widgets/ysc'>Исходный
    код Yii Social Components</a></p>
<p><a href='https://code.google.com/p/xomaprojects/wiki/YiiSocialComponents'>Читать
    документацию</a></p>
</p>

<p>Пакет переодически дополняется новыми виджетами.<p>
<p>Если у Вас есть пожелания или Вы хотите сообщить об ошибке
    - <?php echo CHtml::link('напишите нам', array('/feedback/contact/'))?>
    !</p>

<div style='float:left;padding-right:5px'>
    <?php $this->widget('application.modules.social.widgets.ysc.yandex.YandexShareApi', array(
                                                                                              'type' => 'button',
                                                                                              'services' => 'all'
                                                                                         ));?>
</div>

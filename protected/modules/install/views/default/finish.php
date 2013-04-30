<?php
/**
 * Отображение для finish:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<h1><?php echo Yii::t('InstallModule.install', 'Поздравляем, установка Юпи! завершена!'); ?></h1>

<p><?php echo Yii::t('InstallModule.install', 'Ваш сайт готов к работе!'); ?></p>

<p><?php echo Yii::t('InstallModule.install', 'Если Вам не жалко - отправьте нам чуть-чуть денежек, мы будем довольны =) !'); ?></p>

    <b>Помоги команде!</b><br/><br/>

    Я.Деньгами на <b>41001846363811</b><br/><br/>

    Webmoney на <b>R239262659267</b><br/><br/>

    <b>Спасибо!</b><br/><br/>

<iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?uid=41001846363811&amp;default-sum=100&amp;targets=%d0%a0%d0%b0%d0%b7%d0%b2%d0%b8%d1%82%d0%b8%d0%b5&amp;target-visibility=on&amp;project-name=%d0%ae%d0%bf%d0%b8!+-+%d0%bc%d0%b8%d0%bd%d0%b8+cms+%d0%bd%d0%b0+yii&amp;project-site=http%3a%2f%2fyupe.ru&amp;button-text=01&amp;comment=on&amp;hint=&amp;fio=on" width="450" height="191"></iframe>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'ПЕРЕЙТИ НА САЙТ'), array('/site/index')); ?>

<?php echo Yii::t('InstallModule.install', 'или');?>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'ПЕРЕЙТИ В ПАНЕЛЬ УПРАВЛЕНИЯ'), array('/yupe/backend/index')); ?>

<br/><br/>

<p><?php echo Yii::t('InstallModule.install', 'Полезные ссылки:'); ?></p>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Официальная документация Юпи!'), 'http://yupe.ru/docs/index.html?from=finish'); ?> - <?php echo Yii::t('InstallModule.install', 'Мы активно ее пишем =)'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Официальный сайт Юпи!'), 'http://yupe.ru/?from=finish'); ?> - <?php echo Yii::t('InstallModule.install', 'заходите чаще =)'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Форум поддержки Юпи!'), 'http://yupe.ru/?from=finish'); ?> - <?php echo Yii::t('InstallModule.install', 'интересные мысли и идеи =)'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Официальный твиттер Юпи!'), 'https://twitter.com/#!/YupeCms'); ?>  - <?php echo Yii::t('InstallModule.install', 'обязательно заффоловьте нас, мы не спамим =)'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Исходный код на Github'), 'http://github.com/yupe/yupe/'); ?> - <?php echo Yii::t('InstallModule.install', 'пришлите нам парочку пулл-реквестов, все только выиграют =)'); ?>

<br/><br/>

<?php echo Yii::t('InstallModule.install', 'Пишите нам на <b>team@yupe.ru</b>'); ?>  - <?php echo Yii::t('InstallModule.install', 'принимаем всякого рода коммерческие и любые предложения =)'); ?>
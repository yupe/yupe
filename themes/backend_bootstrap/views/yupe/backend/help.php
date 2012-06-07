<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Юпи!') => array('settings'),
    Yii::t('yupe','Помощь')
);?>

<h1><?php echo Yii::t('yupe', 'Помощь');?></h1>

<br/>

<p><?php echo Yii::t('yupe','Вы используете Yii версии');?>
    <b><?php echo Yii::getVersion();?></b>, <?php echo CHtml::encode(Yii::app()->name);?>
    версии <b><?php echo Yii::app()->getModule('yupe')->getVersion();?></b>,
    php <?php echo Yii::t('yupe', 'версии');?>
    <b><?php echo phpversion();?></b></p>

<br/>

<div class="alert">
    <p><?php echo Yii::t('yupe',' Юпи! разрабатывается и поддерживается командой энтузиастов, Вы можете использовать Юпи! и любую его часть <b>совершенно бесплатно</b>');?></p>

    <?php echo CHtml::link(Yii::t('yupe','А вот здесь мы принимаем благодарности =)'),'http://yupe.ru/site/page/view/help',array('target' => '_blank'));?>

    <p><p><b><?php echo Yii::t('yupe','По вопросам коммерческой поддержки и разработки Вы всегда можете <a href="http://yupe.ru/feedback/contact" target="_blank">написать нам</a> (<a href="http://yupe.ru/feedback/contact" target="_blank">http://yupe.ru/feedback/contact</a>)');?></b></p></p>
</div>

<br/>

<p><?php echo Yii::t('yupe', 'Полезные ресурсы:');?></p>

<?php echo CHtml::link(Yii::t('yupe','Официальный сайт Юпи!'),'http://yupe.ru');?> - <?php echo Yii::t('yupe','заходите чаще =)');?>

<br/><br/>

<?php echo CHtml::link(Yii::t('yupe','Исходный код на Github'),'http://github.com/yupe/yupe/');?> - <?php echo Yii::t('yupe','пришлите нам парочку пулл-реквестов, все только выиграют =)');?>

<br/><br/>

<?php echo CHtml::link(Yii::t('yupe','Официальный твиттер Юпи!'),'https://twitter.com/#!/YupeCms');?>  - <?php echo Yii::t('yupe','обязательно заффоловьте нас, мы не спамим =)');?>

<br/><br/>

Jabber-конференция сервер: conference.yupe.ru, комната: yupe-talks (<a href="http://yupe.ru/post/djabber-konferentsiya-yupi.html">http://yupe.ru/post/djabber-konferentsiya-yupi.html</a>)

<br/><br/>

<?php echo Yii::t('yupe','Напишите нам на <a href="mailto:team@yupe.ru">team@yupe.ru</a>');?>  - <?php echo Yii::t('yupe','принимаем всякого рода коммерческие и любые предложения =)');?>

<br/><br/>

<b><?php echo Yii::t('yupe','Команда разработчиков Юпи!');?></b>

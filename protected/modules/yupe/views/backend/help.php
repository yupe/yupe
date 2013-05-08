<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'Юпи!') => array('settings'),
    Yii::t('YupeModule.yupe','Помощь')
);
?>

<h1><?php echo Yii::t('YupeModule.yupe', 'О Юпи!'); ?></h1>

<p> <?php echo Yii::t('YupeModule.yupe','У каждого большого проекта должна быть страничка "О проекте", у нас она именно здесь =)'); ?></p>

<br/>

<p>
    <?php echo Yii::t('YupeModule.yupe','Вы используете Yii версии'); ?>
    <small class="label label-info" title="<?php echo Yii::getVersion(); ?>"><?php echo Yii::getVersion(); ?></small>,
    <?php echo CHtml::encode(Yii::app()->name); ?>
    <?php echo Yii::t('YupeModule.yupe', 'версии'); ?> <small class="label label-info" title="<?php echo $this->yupe->version; ?>"><?php echo $this->yupe->version; ?></small>,
    <?php echo Yii::t('YupeModule.yupe', 'php версии'); ?>
    <small class="label label-info" title="<?php echo phpversion(); ?>"><?php echo phpversion(); ?></small>
</p>

<br/>

<div class="alert">
    <p>
        <?php echo Yii::t('YupeModule.yupe', ' Юпи! разрабатывается и поддерживается командой энтузиастов, Вы можете использовать Юпи! и любую его часть <b>совершенно бесплатно</b>'); ?>
    </p>
    <?php echo CHtml::link(Yii::t('YupeModule.yupe', 'А вот здесь мы принимаем благодарности =)'), 'http://yupe.ru/pages/help?form=help', array('target' => '_blank')); ?>
    <p><p><b>
        <?php echo Yii::t('YupeModule.yupe', 'По вопросам коммерческой поддержки и разработки Вы всегда можете <a href="http://yupe.ru/feedback/index/?form=help" target="_blank">написать нам</a> (<a href="http://yupe.ru/feedback/index/?form=help" target="_blank">http://yupe.ru/feedback/index</a>)'); ?>
    </b></p></p>
</div>

<div class="alert">
    <p><?php echo Yii::t('YupeModule.yupe','Помоги команде!');?></p>
    <p><?php echo Yii::t('YupeModule.yupe','Я.Деньгами на');?> <b>41001846363811</b></p>
    <p><?php echo Yii::t('YupeModule.yupe','Webmoney на')?> <b>R239262659267</b></p>
</div>

<br />

<p><b><?php echo Yii::t('YupeModule.yupe', 'Полезные ресурсы:');?></b></p>

<?php echo CHtml::link(Yii::t('YupeModule.yupe','Обязательно прочтите документацию Yii'),'http://yiiframework.ru/doc/guide/ru/index');?>
<br /><br />


<?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Официальный сайт Юпи!'), 'http://yupe.ru/?form=help'); ?> - <?php echo Yii::t('YupeModule.yupe', 'заходите чаще!'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Официальная документация Юпи!'), 'http://yupe.ru/docs/index.html?form=help'); ?> - <?php echo Yii::t('YupeModule.yupe', 'активно ее пишем =)'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Дополнительные модули и компоненты'), 'https://github.com/yupe/yupe-ext'); ?> - <?php echo Yii::t('YupeModule.yupe', 'присылайте свои наработки !'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Форум поддержки Юпи!'), 'http://yupe.ru/talk/?form=help'); ?> - <?php echo Yii::t('YupeModule.yupe', 'заходите поболтать!'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Исходный код на Github'), 'http://github.com/yupe/yupe/'); ?> - <?php echo Yii::t('YupeModule.yupe', 'пришлите нам парочку пулл-реквестов, все только выиграют =)'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.yupe', 'Официальный твиттер Юпи!'), 'https://twitter.com/#!/YupeCms'); ?>  - <?php echo Yii::t('YupeModule.yupe', 'обязательно заффоловьте нас, мы не спамим =)'); ?>

<br /><br />

<div class="alert">
    <?php echo Yii::t('YupeModule.yupe', 'Напишите нам на <a href="mailto:team@yupe.ru">team@yupe.ru</a> или через форму {link}',array('{link}' => CHtml::link('обратной связи','http://yupe.ru/feedback/index?from=help',array('target' => '_blank')))); ?>  - <?php echo Yii::t('YupeModule.yupe', 'принимаем всякого рода коммерческие и любые предложения =)'); ?>
</div>

<br />

<b><?php echo Yii::t('YupeModule.yupe','Команда разработчиков Юпи!'); ?>:</b>

<br /><br />

<table class="detail-view table table-striped table-condensed" id="yupe-core-team">
    <tbody>
         <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Опейкин Андрей');?></th>
            <td><?php echo CHtml::link('andrey.opeykin.ru','http://andrey.opeykin.ru?from=yupe_help');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Тищенко Александр');?></th>
            <td><?php echo CHtml::link('twitter.com/archaron','https://twitter.com/archaron');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Лыженков Александр');?></th>
            <td><?php echo CHtml::link('lyzhenkov.ru','http://lyzhenkov.ru?from=yupe_help');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Елизаров Алексей');?></th>
            <td><?php echo CHtml::link('vk.com/valaraukar','http://vk.com/valaraukar');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Куликов Евгений');?></th>
            <td><?php echo CHtml::link('akulikov.org.ua','http://akulikov.org.ua?from=yupe_help');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Тимашов Максим');?></th>
            <td>apexwire@gmail.com</td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Черепанов Антон');?></th>
            <td><?php echo CHtml::link('twitter.com/davetoxa','https://twitter.com/davetoxa');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.yupe','Николай Седов');?></th>
            <td><?php echo CHtml::link('https://twitter.com/mik_spark','https://twitter.com/mik_spark');?></td>
        </tr>
    </tbody>
</table>

<b><?php echo CHtml::link(Yii::t('YupeModule.yupe','ЖДЕМ ТОЛЬКО ТЕБЯ!'),'http://yupe.ru/feedback/index?from=help',array('target' => '_blank'));?></b>

<br/><br/>



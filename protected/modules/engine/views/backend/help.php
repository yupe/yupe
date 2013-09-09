<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.engine', 'Юпи!') => array('settings'),
    Yii::t('YupeModule.engine','Помощь')
);
?>

<h1><?php echo Yii::t('YupeModule.engine', 'О Юпи!'); ?></h1>

<p> <?php echo Yii::t('YupeModule.engine','У каждого большого проекта должна быть страничка "О проекте", у нас она именно здесь =)'); ?></p>

<br/>

<p>
    <?php echo Yii::t('YupeModule.engine','Вы используете Yii версии'); ?>
    <small class="label label-info" title="<?php echo Yii::getVersion(); ?>"><?php echo Yii::getVersion(); ?></small>,
    <?php echo CHtml::encode(Yii::app()->name); ?>
    <?php echo Yii::t('YupeModule.engine', 'версии'); ?> <small class="label label-info" title="<?php echo $this->yupe->version; ?>"><?php echo $this->yupe->version; ?></small>,
    <?php echo Yii::t('YupeModule.engine', 'php версии'); ?>
    <small class="label label-info" title="<?php echo phpversion(); ?>"><?php echo phpversion(); ?></small>
</p>

<br/>

<div class="alert">
    <p>
        <?php echo Yii::t('YupeModule.engine', ' Юпи! разрабатывается и поддерживается командой энтузиастов, Вы можете использовать Юпи! и любую его часть <b>совершенно бесплатно</b>'); ?>
    </p>
    <?php echo CHtml::link(Yii::t('YupeModule.engine', 'А вот здесь мы принимаем благодарности =)'), 'http://engine.ru/pages/help?form=help', array('target' => '_blank')); ?>
    <p><p><b>
        <?php echo Yii::t('YupeModule.engine', 'По вопросам коммерческой поддержки и разработки Вы всегда можете <a href="http://engine.ru/feedback/index/?form=help" target="_blank">написать нам</a> (<a href="http://engine.ru/feedback/index/?form=help" target="_blank">http://engine.ru/feedback/index</a>)'); ?>
    </b></p></p>
</div>

<div class="alert">
    <p><?php echo Yii::t('YupeModule.engine','Помоги команде!');?></p>
    <p><?php echo Yii::t('YupeModule.engine','Я.Деньгами на');?> <b>41001846363811</b></p>
    <p><?php echo Yii::t('YupeModule.engine','Webmoney на')?> <b>R239262659267</b></p>
</div>

<br />

<p><b><?php echo Yii::t('YupeModule.engine', 'Полезные ресурсы:');?></b></p>

<?php echo CHtml::link(Yii::t('YupeModule.engine','Обязательно прочтите документацию Yii', array('target' => '_blank')),'http://yiiframework.ru/doc/guide/ru/index');?>
<br /><br />


<?php echo CHtml::link(Yii::t('YupeModule.engine', 'Официальный сайт Юпи!', array('target' => '_blank')), 'http://engine.ru/?form=help'); ?> - <?php echo Yii::t('YupeModule.engine', 'заходите чаще!'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.engine', 'Официальная документация Юпи!', array('target' => '_blank')), 'http://engine.ru/docs/index.html?form=help'); ?> - <?php echo Yii::t('YupeModule.engine', 'активно ее пишем =)'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.engine', 'Дополнительные модули и компоненты'), 'https://github.com/engine/engine-ext', array('target' => '_blank')); ?> - <?php echo Yii::t('YupeModule.engine', 'присылайте свои наработки !'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.engine', 'Форум поддержки Юпи!'), 'http://engine.ru/talk/?form=help', array('target' => '_blank')); ?> - <?php echo Yii::t('YupeModule.engine', 'заходите поболтать!'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.engine', 'Исходный код на Github'), 'http://github.com/engine/engine/', array('target' => '_blank')); ?> - <?php echo Yii::t('YupeModule.engine', 'пришлите нам парочку пулл-реквестов, все только выиграют =)'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('YupeModule.engine', 'Официальный твиттер Юпи!'), 'https://twitter.com/#!/YupeCms', array('target' => '_blank')); ?>  - <?php echo Yii::t('YupeModule.engine', 'обязательно заффоловьте нас, мы не спамим =)'); ?>

<br /><br />

<?php echo CHtml::link(Yii::t('install', 'Генеральный спонсор'), 'http://amylabs.ru?from=engine-help', array('target' => '_blank')); ?> - <?php echo Yii::t('install', 'Просто отличные парни =)'); ?>

<br /><br />

<div class="alert">
    <?php echo Yii::t('YupeModule.engine', 'Напишите нам на <a href="mailto:team@engine.ru">team@engine.ru</a> или через форму {link}',array('{link}' => CHtml::link('обратной связи','http://engine.ru/feedback/index?from=help',array('target' => '_blank')))); ?>  - <?php echo Yii::t('YupeModule.engine', 'принимаем всякого рода коммерческие и любые предложения =)'); ?>
</div>

<br />

<b><?php echo Yii::t('YupeModule.engine','Команда разработчиков Юпи!'); ?></b>

<br /><br />

<table class="detail-view table table-striped table-condensed" id="yupe-core-team">
    <tbody>
         <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Опейкин Андрей');?></th>
            <td><?php echo CHtml::link('andrey.opeykin.ru','http://andrey.opeykin.ru?from=yupe_help');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Тищенко Александр');?></th>
            <td><?php echo CHtml::link('twitter.com/archaron','https://twitter.com/archaron');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Лыженков Александр');?></th>
            <td><?php echo CHtml::link('lyzhenkov.ru','http://lyzhenkov.ru?from=yupe_help');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Елизаров Алексей');?></th>
            <td><?php echo CHtml::link('vk.com/valaraukar','http://vk.com/valaraukar');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Куликов Евгений');?></th>
            <td><?php echo CHtml::link('akulikov.org.ua','http://akulikov.org.ua?from=yupe_help');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Тимашов Максим');?></th>
            <td>apexwire@gmail.com</td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Черепанов Антон');?></th>
            <td><?php echo CHtml::link('twitter.com/davetoxa','https://twitter.com/davetoxa');?></td>
        </tr>
        <tr class="odd">
            <th><?php echo Yii::t('YupeModule.engine','Седов Николай');?></th>
            <td><?php echo CHtml::link('https://twitter.com/mik_spark','https://twitter.com/mik_spark');?></td>
        </tr>
         <tr class="odd">
             <th><?php echo Yii::t('YupeModule.engine','Кучеров Антон');?></th>
             <td><?php echo CHtml::link('http://idexter.ru/','http://idexter.ru/');?></td>
         </tr>
    </tbody>
</table>

<b><?php echo CHtml::link(Yii::t('YupeModule.engine','ЖДЕМ ТОЛЬКО ТЕБЯ!'),'http://engine.ru/feedback/index?from=help',array('target' => '_blank'));?></b>

<br/><br/>



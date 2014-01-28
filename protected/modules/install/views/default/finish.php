<?php
/**
 * Отображение для finish:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<h1><?php echo Yii::t('InstallModule.install', 'Congratulations Yupe was installed successfully!'); ?></h1>

<p><?php echo Yii::t('InstallModule.install', 'Your site is ready to work!'); ?></p>

<div class="alert alert-block alert-notice">

    <p><?php echo Yii::t('InstallModule.install', 'You can donate us some money if you like our project.'); ?></p>

        <b><?php echo  Yii::t('InstallModule.install', 'Help us!');?></b><br/><br/>

        Я.Деньги <b>41001846363811</b><br/><br/>

        <b><?php echo  Yii::t('InstallModule.install', 'Thank you!');?></b><br/><br/>

    <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/donate.xml?uid=41001846363811&amp;default-sum=100&amp;targets=%d0%a0%d0%b0%d0%b7%d0%b2%d0%b8%d1%82%d0%b8%d0%b5&amp;target-visibility=on&amp;project-name=%d0%ae%d0%bf%d0%b8!+-+%d0%bc%d0%b8%d0%bd%d0%b8+cms+%d0%bd%d0%b0+yii&amp;project-site=http%3a%2f%2fyupe.ru&amp;button-text=01&amp;comment=on&amp;hint=&amp;fio=on" width="450" height="191"></iframe>

</div>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'GO TO SITE HOME PAGE'), array(Yii::app()->baseUrl)); ?>

<?php echo Yii::t('InstallModule.install', 'or');?>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'GO TO CONTROL PANEL'), array('/yupe/backend/index')); ?>

<br/><br/>

<p><?php echo Yii::t('InstallModule.install', 'Interesting links:'); ?></p>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Official docs'), 'http://yupe.ru/docs/index.html?from=finish'); ?> - <?php echo Yii::t('InstallModule.install', 'We working with it'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Official Yupe site'), 'http://yupe.ru/?from=finish'); ?> - <?php echo Yii::t('InstallModule.install', 'go frequently'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Support Yupe forum'), 'http://yupe.ru/?from=finish'); ?> - <?php echo Yii::t('InstallModule.install', 'interesing thoughts and ideas'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Official Yupe twitter'), 'https://twitter.com/#!/yupe'); ?>  - <?php echo Yii::t('InstallModule.install', 'Follow us'); ?>

<br/><br/>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'Sources on GitHub'), 'http://github.com/yupe/yupe/'); ?> - <?php echo Yii::t('InstallModule.install', 'Send pull request'); ?>

<br/><br/>

<?php echo Yii::t('InstallModule.install', 'Mail us to <b><a href="mailto:team@yupe.ru">team@yupe.ru</a></b>'); ?>  - <?php echo Yii::t('InstallModule.install', 'We always open for commercial and other propositions'); ?>
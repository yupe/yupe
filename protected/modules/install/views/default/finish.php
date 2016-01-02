<?php
/**
 * Отображение для finish:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<h1><?php echo Yii::t('InstallModule.install', 'Congratulations Yupe was installed successfully!'); ?></h1>

<p><?php echo Yii::t('InstallModule.install', 'Your site is ready to work!'); ?></p>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'GO TO SITE HOME PAGE'), ['/site/index']); ?>

<?php echo Yii::t('InstallModule.install', 'or'); ?>

<?php echo CHtml::link(Yii::t('InstallModule.install', 'GO TO CONTROL PANEL'), ['/yupe/backend/index']); ?>

<br/><br/>

<p><?php echo Yii::t('InstallModule.install', 'Interesting links:'); ?></p>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', 'Official Yupe site'),
    'http://yupe.ru/?from=finish'
); ?> - <?php echo Yii::t('InstallModule.install', 'go frequently'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', 'Community'),
    'http://yupe.ru/?from=finish'
); ?> - <?php echo Yii::t('InstallModule.install', 'go frequently'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', 'Official docs'),
    'http://yupe.ru/docs/index.html?from=finish'
); ?> - <?php echo Yii::t('InstallModule.install', 'We working with it'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', 'Support Yupe forum'),
    'http://yupe.ru/?from=finish'
); ?> - <?php echo Yii::t('InstallModule.install', 'interesing thoughts and ideas'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', 'Official Yupe twitter'),
    'https://twitter.com/yupecms'
); ?>  - <?php echo Yii::t('InstallModule.install', 'Follow us'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', 'Sources on GitHub'),
    'http://github.com/yupe/yupe/'
); ?> - <?php echo Yii::t('InstallModule.install', 'Send pull request'); ?>

<br/><br/>

<?php echo Yii::t(
    'InstallModule.install',
    'Mail us to <b><a href="mailto:team@yupe.ru">team@yupe.ru</a></b>'
); ?>  - <?php echo Yii::t(
    'InstallModule.install',
    'We always open for commercial and other propositions'
); ?>

<?php
/**
 * Отображение для finish:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 **/
?>
<h3><?= Yii::t('InstallModule.install', 'Congratulations Yupe was installed successfully!'); ?></h3>

<p><?= Yii::t('InstallModule.install', 'Your store is ready to work!'); ?></p>

<hr/>

<?= Yii::t('InstallModule.install', 'Share with your friends!'); ?>

<script type="text/javascript" src="//yastatic.net/es5-shims/0.0.2/es5-shims.min.js" charset="utf-8"></script>
<script type="text/javascript" src="//yastatic.net/share2/share.js" charset="utf-8"></script>

<div class="ya-share2"
     data-services="vkontakte,facebook,odnoklassniki,moimir,gplus,twitter,evernote,lj,surfingbird,whatsapp"
     data-description="<?= Yii::t('InstallModule.install', 'Free online store!'); ?>"
     data-tile="<?= Yii::t('InstallModule.install', 'Free online store!'); ?>"
     data-url="https://yupe.ru">
</div>

<hr/>

<?= CHtml::link(Yii::t('InstallModule.install', 'GO TO SITE HOME PAGE'), '/',
    ['class' => 'btn btn-info']); ?>

<?= Yii::t('InstallModule.install', 'or'); ?>

<?= CHtml::link(Yii::t('InstallModule.install', 'GO TO CONTROL PANEL'), ['/yupe/backend/index'],
    ['class' => 'btn btn-info']); ?>

<br/>
<hr/>


<p><?= Yii::t('InstallModule.install', 'Interesting links:'); ?></p>

<?= CHtml::link(
    Yii::t('InstallModule.install', 'Official Yupe site'),
    'https://yupe.ru/?from=finish',
    ['target' => '_blank']
); ?> - <?= Yii::t('InstallModule.install', 'go frequently'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('InstallModule.install', 'Hosting'),
    'https://yupe.ru/service/hosting?from=finish',
    ['target' => '_blank']
); ?> - <?= Yii::t('InstallModule.install', 'Hosting for your store'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('InstallModule.install', 'Official docs'),
    'http://docs.yupe.ru/?from=finish',
    ['target' => '_blank']
); ?> - <?= Yii::t('InstallModule.install', 'We working with it'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('InstallModule.install', 'Support Yupe forum'),
    'http://talk.yupe.ru/?from=finish',
    ['target' => '_blank']
); ?> - <?= Yii::t('InstallModule.install', 'interesing thoughts and ideas'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('InstallModule.install', 'Official Yupe twitter'),
    'https://twitter.com/yupecms',
    ['target' => '_blank']
); ?>  - <?= Yii::t('InstallModule.install', 'Follow us'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('InstallModule.install', 'Sources on GitHub'),
    'http://github.com/yupe/yupe/'
); ?> - <?= Yii::t('InstallModule.install', 'Send pull request'); ?>

<br/><br/>

<?= Yii::t(
    'InstallModule.install',
    'Mail us to <b><a href="mailto:team@yupe.ru">support@yupe.ru</a></b>'
); ?>  - <?= Yii::t(
    'InstallModule.install',
    'We always open for commercial and other propositions'
); ?>

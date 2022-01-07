<?php
$this->breadcrumbs = [
    Yii::t('YupeModule.yupe', 'Yupe!') => ['settings'],
    Yii::t('YupeModule.yupe', 'Help'),
];
?>

<h1><?= Yii::t('YupeModule.yupe', 'About Yupe!'); ?></h1>

<p>
    <?= Yii::t('YupeModule.yupe', 'You use Yii version'); ?>
    <small class="label label-info" title="<?= Yii::getVersion(); ?>"><?= Yii::getVersion(); ?></small>
    ,
    <?= CHtml::encode(Yii::app()->name); ?>
    <?= Yii::t('YupeModule.yupe', 'version'); ?>
    <small class="label label-info"
           title="<?= $this->yupe->version; ?>"><?= $this->yupe->version; ?></small>
    ,
    <?= Yii::t('YupeModule.yupe', 'php version'); ?>
    <small class="label label-info" title="<?= phpversion(); ?>"><?= phpversion(); ?></small>
</p>


<p><b><?= Yii::t('YupeModule.yupe', 'Interesting resources:'); ?></b></p>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Read Yii documentation', ['target' => '_blank']),
    'http://yiiframework.com/doc/guide/index'
); ?>
<br/><br/>


<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! site', ['target' => '_blank']),
    'https://yupe.ru/?form=help'
); ?> - <?= Yii::t('YupeModule.yupe', 'use most!'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Community', ['target' => '_blank']),
    'https://yupe.ru/?form=help'
); ?> - <?= Yii::t('YupeModule.yupe', 'use most!'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! docs', ['target' => '_blank']),
    'http://docs.yupe.ru/?form=help'
); ?> - <?= Yii::t(
    'YupeModule.yupe',
    ' We are working with it =)'
); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Sources on Github'),
    'http://github.com/yupe/yupe/',
    ['target' => '_blank']
); ?> - <?= Yii::t(
    'YupeModule.yupe',
    'Send pull request for us =)'
); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! twitter'),
    'https://twitter.com/#!/yupe',
    ['target' => '_blank']
); ?>  - <?= Yii::t('YupeModule.yupe', 'Follow us =)'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'General sponsor'),
    'https://yupe.ru?from=yupe-help',
    ['target' => '_blank']
); ?> - <?= Yii::t(
    'YupeModule.yupe',
    'Just great guys =)'
); ?>

<br/><br/>

<div class="alert alert-warning">
    <?= Yii::t(
        'YupeModule.yupe',
        'Feedback at <a href="mailto:support@yupe.ru">support@yupe.ru</a> or {link}',
        [
            '{link}' => CHtml::link(
                Yii::t('YupeModule.yupe', 'feedback form'),
                'https://yupe.ru/contacts?from=help',
                ['target' => '_blank']
            ),
        ]
    ); ?> - <?= Yii::t('YupeModule.yupe', 'accept any kind of business and any proposals =)'); ?>
</div>

<br/>

<b><?= Yii::t('YupeModule.yupe', 'Yupe! developers team'); ?></b>



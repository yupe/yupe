<?php
$this->breadcrumbs = [
    Yii::t('YupeModule.yupe', 'Yupe!') => ['settings'],
    Yii::t('YupeModule.yupe', 'Help'),
];
?>

<h1><?= Yii::t('YupeModule.yupe', 'About Yupe!'); ?></h1>

<p> <?= Yii::t('YupeModule.yupe', 'Any project must have About page. So it is here =)'); ?></p>

<br/>

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

<br/>

<div class="alert alert-warning">
    <p>
        <?= Yii::t(
            'YupeModule.yupe',
            ' Yupe! developed and maintained by a team of enthusiasts, you can use Yupe! and any part of it <b>absolutely for free</b>!'
        ); ?>
    </p>
    <?= CHtml::link(
        Yii::t('YupeModule.yupe', 'There is a page for tahnks =)'),
        'http://yupe.ru/pages/help?form=help',
        ['target' => '_blank']
    ); ?>
    <p><b>
            <?= Yii::t(
                'YupeModule.yupe',
                'On business support and development you can always <a href="http://yupe.ru/contacts/?form=help" target="_blank">feedback us</a> (<a href="http://yupe.ru/contacts/?form=help" target="_blank">http://yupe.ru/contacts</a>)'
            ); ?>
        </b></p>
</div>

<p><b><?= Yii::t('YupeModule.yupe', 'Interesting resources:'); ?></b></p>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Read Yii documentation', ['target' => '_blank']),
    'http://yiiframework.com/doc/guide/index'
); ?>
<br/><br/>


<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! site', ['target' => '_blank']),
    'http://yupe.ru/?form=help'
); ?> - <?= Yii::t('YupeModule.yupe', 'use most!'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Community', ['target' => '_blank']),
    'http://yupe.ru/?form=help'
); ?> - <?= Yii::t('YupeModule.yupe', 'use most!'); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! docs', ['target' => '_blank']),
    'http://yupe.ru/docs/index.html?form=help'
); ?> - <?= Yii::t(
    'YupeModule.yupe',
    ' We are working with it =)'
); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Additional modules and components'),
    'http://yupe.ru/marketplace',
    ['target' => '_blank']
); ?> - <?= Yii::t(
    'YupeModule.yupe',
    'Submit an extension!'
); ?>

<br/><br/>

<?= CHtml::link(
    Yii::t('YupeModule.yupe', 'Support Yupe! forum'),
    'http://yupe.ru/talk/?form=help',
    ['target' => '_blank']
); ?> - <?= Yii::t('YupeModule.yupe', 'Lest\'s talk!'); ?>

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
    'http://amylabs.ru?from=yupe-help',
    ['target' => '_blank']
); ?> - <?= Yii::t(
    'YupeModule.yupe',
    'Just great guys =)'
); ?>

<br/><br/>

<div class="alert alert-warning">
    <?= Yii::t(
        'YupeModule.yupe',
        'Feedback at <a href="mailto:team@yupe.ru">team@yupe.ru</a> or {link}',
        [
            '{link}' => CHtml::link(
                Yii::t('YupeModule.yupe', 'feedback form'),
                'http://yupe.ru/contacts?from=help',
                ['target' => '_blank']
            ),
        ]
    ); ?> - <?= Yii::t('YupeModule.yupe', 'accept any kind of business and any proposals =)'); ?>
</div>

<br/>

<b><?= Yii::t('YupeModule.yupe', 'Yupe! developers team'); ?></b>



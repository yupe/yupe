<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'Yupe!') => array('settings'),
    Yii::t('YupeModule.yupe', 'Help')
);
?>

<h1><?php echo Yii::t('YupeModule.yupe', 'About Yupe!'); ?></h1>

<p> <?php echo Yii::t('YupeModule.yupe', 'Any project must have About page. So it is here =)'); ?></p>

<br/>

<p>
    <?php echo Yii::t('YupeModule.yupe', 'You use Yii version'); ?>
    <small class="label label-info" title="<?php echo Yii::getVersion(); ?>"><?php echo Yii::getVersion(); ?></small>
    ,
    <?php echo CHtml::encode(Yii::app()->name); ?>
    <?php echo Yii::t('YupeModule.yupe', 'version'); ?>
    <small class="label label-info"
           title="<?php echo $this->yupe->version; ?>"><?php echo $this->yupe->version; ?></small>
    ,
    <?php echo Yii::t('YupeModule.yupe', 'php version'); ?>
    <small class="label label-info" title="<?php echo phpversion(); ?>"><?php echo phpversion(); ?></small>
</p>

<br/>

<div class="alert alert-warning">
    <p>
        <?php echo Yii::t(
            'YupeModule.yupe',
            ' Yupe! developed and maintained by a team of enthusiasts, you can use Yupe! and any part of it <b>absolutely for free</b>!'
        ); ?>
    </p>
    <?php echo CHtml::link(
        Yii::t('YupeModule.yupe', 'There is a page for tahnks =)'),
        'http://yupe.ru/pages/help?form=help',
        array('target' => '_blank')
    ); ?>
    <p><b>
            <?php echo Yii::t(
                'YupeModule.yupe',
                'On business support and development you can always <a href="http://yupe-project.ru/contacts/?form=help" target="_blank">feedback us</a> (<a href="http://yupe-project.ru/contacts/?form=help" target="_blank">http://yupe-project.ru/contacts</a>)'
            ); ?>
        </b></p>
</div>

<p><b><?php echo Yii::t('YupeModule.yupe', 'Interesting resources:'); ?></b></p>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Read Yii documentation', array('target' => '_blank')),
    'http://yiiframework.com/doc/guide/index'
); ?>
<br/><br/>


<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! site', array('target' => '_blank')),
    'http://yupe-project.ru/?form=help'
); ?> - <?php echo Yii::t('YupeModule.yupe', 'use most!'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Community', array('target' => '_blank')),
    'http://yupe.ru/?form=help'
); ?> - <?php echo Yii::t('YupeModule.yupe', 'use most!'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! docs', array('target' => '_blank')),
    'http://yupe.ru/docs/index.html?form=help'
); ?> - <?php echo Yii::t(
    'YupeModule.yupe',
    ' We are working with it =)'
); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Additional modules and components'),
    'https://github.com/yupe/yupe-ext',
    array('target' => '_blank')
); ?> - <?php echo Yii::t(
    'YupeModule.yupe',
    'Submit an extension!'
); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Support Yupe! forum'),
    'http://yupe.ru/talk/?form=help',
    array('target' => '_blank')
); ?> - <?php echo Yii::t('YupeModule.yupe', 'Lest\'s talk!'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Sources on Github'),
    'http://github.com/yupe/yupe/',
    array('target' => '_blank')
); ?> - <?php echo Yii::t(
    'YupeModule.yupe',
    'Send pull request for us =)'
); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'Official Yupe! twitter'),
    'https://twitter.com/#!/yupe',
    array('target' => '_blank')
); ?>  - <?php echo Yii::t('YupeModule.yupe', 'Follow us =)'); ?>

<br/><br/>

<?php echo CHtml::link(
    Yii::t('YupeModule.yupe', 'General sponsor'),
    'http://amylabs.ru?from=yupe-help',
    array('target' => '_blank')
); ?> - <?php echo Yii::t(
    'YupeModule.yupe',
    'Just great guys =)'
); ?>

<br/><br/>

<div class="alert alert-warning">
    <?php echo Yii::t(
        'YupeModule.yupe',
        'Feedback at <a href="mailto:team@yupe.ru">team@yupe.ru</a> or {link}',
        array(
            '{link}' => CHtml::link(
                    Yii::t('YupeModule.yupe', 'feedback form'),
                    'http://yupe-project.ru/contacts?from=help',
                    array('target' => '_blank')
                )
        )
    ); ?>  - <?php echo Yii::t('YupeModule.yupe', 'accept any kind of business and any proposals =)'); ?>
</div>

<br/>

<b><?php echo Yii::t('YupeModule.yupe', 'Yupe! developers team'); ?></b>

<br/><br/>

<table class="detail-view table table-striped table-striped condensed" id="yupe-core-team">
    <tbody>
    <tr class="odd">
        <th><?php echo Yii::t('YupeModule.yupe', 'Opeykin Andrey'); ?></th>
        <td><?php echo CHtml::link('amylabs.ru', 'http://amylabs.ru?from=yupe_help'); ?></td>
    </tr>
    <tr class="odd">
        <th><?php echo Yii::t('YupeModule.yupe', 'Sedov Nikolay'); ?></th>
        <td><?php echo CHtml::link('amylabs.ru', 'http://amylabs.ru?from=yupe_help'); ?></td>
    </tr>
    <tr class="odd">
        <th><?php echo Yii::t('YupeModule.yupe', 'Kucherov Anton'); ?></th>
        <td><?php echo CHtml::link('idexter.ru', 'http://idexter.ru/'); ?></td>
    </tr>
    <tr class="odd">
        <th><?php echo Yii::t('YupeModule.yupe', 'Timashov Maxim'); ?></th>
        <td><?php echo CHtml::link('amylabs.ru', 'http://amylabs.ru?from=yupe_help'); ?></td>
    </tr>

    <tr class="odd">
        <th><?php echo Yii::t('YupeModule.yupe', 'Mihail Chemezov'); ?></th>
        <td><?php echo CHtml::link('amylabs.ru', 'http://vk.com/m.chemezov'); ?></td>
    </tr>

    <tr class="odd">
        <th><?php echo Yii::t('YupeModule.yupe', 'Plaksunov Yuri'); ?></th>
        <td><?php echo CHtml::link('amylabs.ru', 'http://amylabs.ru?from=yupe_help'); ?></td>
    </tr>


    </tbody>
</table>

<b><?php echo CHtml::link(
        Yii::t('YupeModule.yupe', 'WE ARE WAITING FOR YOU!'),
        'http://yupe.ru/contacts?from=help',
        array('target' => '_blank')
    ); ?></b>

<br/><br/>

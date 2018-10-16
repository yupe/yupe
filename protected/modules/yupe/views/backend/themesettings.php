<?php
$this->breadcrumbs = [
    Yii::t('YupeModule.yupe', 'System') => ['settings'],
    Yii::t('YupeModule.yupe', 'Themes'),
];
?>

<h1><?= Yii::t('YupeModule.yupe', 'Theme choise'); ?></h1>

<div class="alert alert-block alert-info">
    <?= Yii::t('YupeModule.yupe', 'Current theme'); ?>: <b><?= $theme; ?></b>,
    <?= Yii::t('YupeModule.yupe', 'Current backend theme'); ?>: <b><?= $backendTheme; ?></b>

    <p><?= CHtml::link(
            Yii::t('YupeModule.yupe', 'More about themes'),
            'http://yiiframework.com/doc/guide/topics.theming',
            ['target' => '_blank']
        ); ?></p>
</div>


<?= CHtml::beginForm(['/yupe/backend/themesettings', 'post'], 'post', ['class' => 'well']); ?>
<div class="form-group">
    <?= CHtml::label(Yii::t('YupeModule.yupe', 'Choose site theme'), 'theme'); ?>
    <div class="row">
        <div class="col-xs-5">
            <?= CHtml::dropDownList('theme', $theme, $themes, ['class' => 'form-control']); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <?= CHtml::label(Yii::t('YupeModule.yupe', 'Choose backend theme'), 'backendTheme'); ?>
    <div class="row">
        <div class="col-xs-5">
            <?= CHtml::dropDownList(
                'backendTheme',
                $backendTheme,
                $backendThemes,
                ['class' => 'form-control', 'empty' => Yii::t('YupeModule.yupe', 'Theme is not using')]
            ); ?>
        </div>
    </div>
</div>
<br/><br/>
<?= CHtml::submitButton(
    Yii::t('YupeModule.yupe', 'Save themes settings'),
    ['class' => 'btn btn-primary']
); ?>

<?= CHtml::endForm(); ?>

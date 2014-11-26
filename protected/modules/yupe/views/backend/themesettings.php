<?php
$this->breadcrumbs = [
    Yii::t('YupeModule.yupe', 'System') => ['settings'],
    Yii::t('YupeModule.yupe', 'Themes'),
];
?>

<h1><?php echo Yii::t('YupeModule.yupe', 'Theme choise'); ?></h1>

<div class="alert alert-block alert-info">
    <?php echo Yii::t('YupeModule.yupe', 'Current theme'); ?>: <b><?php echo $theme; ?></b>,
    <?php echo Yii::t('YupeModule.yupe', 'Current backend theme'); ?>: <b><?php echo $backendTheme; ?></b>

    <p><?php echo CHtml::link(
            Yii::t('YupeModule.yupe', 'More about themes'),
            'http://yiiframework.com/doc/guide/topics.theming',
            ['target' => '_blank']
        ); ?></p>
</div>


<?php echo CHtml::beginForm(['/yupe/backend/themesettings', 'post'], 'post', ['class' => 'well']); ?>
<div class="form-group">
    <?php echo CHtml::label(Yii::t('YupeModule.yupe', 'Choose site theme'), 'theme'); ?>
    <div class="row">
        <div class="col-xs-5">
            <?php echo CHtml::dropDownList('theme', $theme, $themes, ['class' => 'form-control']); ?>
        </div>
    </div>
</div>
<div class="form-group">
    <?php echo CHtml::label(Yii::t('YupeModule.yupe', 'Choose backend theme'), 'backendTheme'); ?>
    <div class="row">
        <div class="col-xs-5">
            <?php echo CHtml::dropDownList(
                'backendTheme',
                $backendTheme,
                $backendThemes,
                ['class' => 'form-control', 'empty' => Yii::t('YupeModule.yupe', 'Theme is not using')]
            ); ?>
        </div>
    </div>
</div>
<br/><br/>
<?php echo CHtml::submitButton(
    Yii::t('YupeModule.yupe', 'Save themes settings'),
    ['class' => 'btn btn-primary']
); ?>

<?php echo CHtml::endForm(); ?>

<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'userName'); ?>
        <?php echo CHtml::activeTextField($model, 'userName') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'email'); ?> (<?php echo Yii::t('install','используется для авторизации в панели управления)');?><br/>
        <?php echo CHtml::activeTextField($model, 'email') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'password'); ?>
        <?php echo CHtml::activePasswordField($model, 'password') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'cPassword'); ?>
        <?php echo CHtml::activePasswordField($model, 'cPassword') ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Продолжить >>>');?>
    </div>

    <?php echo CHtml::endForm(); ?>
</div><!-- form -->


<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'email'); ?>
        <?php echo CHtml::activeTextField($model, 'email') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'siteName'); ?>
        <?php echo CHtml::activeTextField($model, 'siteName') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'siteDescription'); ?>
        <?php echo CHtml::activeTextArea($model, 'siteDescription', array('rows' => 10, 'cols' => 50)); ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'siteKeyWords'); ?>
        <?php echo CHtml::activeTextArea($model, 'siteKeyWords', array('rows' => 10, 'cols' => 50)); ?>
    </div>

    <div class="row submit">
        <?php echo CHtml::submitButton('Продолжить >>>');?>
    </div>

    <?php echo CHtml::endForm(); ?>
</div><!-- form -->


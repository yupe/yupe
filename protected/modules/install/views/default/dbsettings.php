<p><?php echo Yii::t('install', 'Укажите параметры соединения с базой данных')?>
    :</p>


<?php if (!$result): ?>
<div class="flash-error">
    <b><?php echo Yii::t('yupe', "Файл {file} не существует или не доступен для записи!", array('{file}' => $file));?></b>
</div>
<?php endif; ?>


<?php if (!$sqlResult): ?>
<div class="flash-error">
    <b><?php echo Yii::t('yupe', "Файл {file} не существует или не доступен для чтения!", array('{file}' => $sqlFile));?></b>
</div>
<?php endif; ?>


<div class="form">

    <?php echo CHtml::beginForm(); ?>

    <?php echo CHtml::errorSummary($model); ?>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'host'); ?>
        <?php echo CHtml::activeTextField($model, 'host') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'port'); ?>
        <?php echo CHtml::activeTextField($model, 'port') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'dbName'); ?>
        <?php echo CHtml::activeTextField($model, 'dbName') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'user'); ?>
        <?php echo CHtml::activeTextField($model, 'user') ?>
    </div>

    <div class="row">
        <?php echo CHtml::activeLabel($model, 'password'); ?>
        <?php echo CHtml::activePasswordField($model, 'password') ?>
    </div>

    <?php if ($result && $sqlResult): ?>
    <div class="row submit">
        <?php echo CHtml::submitButton('Продолжить >>>');?>
    </div>
    <?php endif;?>

    <?php echo CHtml::endForm(); ?>
</div><!-- form -->







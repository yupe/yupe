<?php if (!$result): ?>
<div class="flash-error">
    <b><?php echo Yii::t('yupe', 'Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!');?></b>
</div>
<?php endif; ?>

<table class="result">

    <tr>
        <th>Значение</th>
        <th>Результат</th>
        <th>Комментарий</th>
    </tr>
    <?php foreach ($requirements as $requirement): ?>
    <tr>
        <td width="200"><?php echo $requirement[0]; ?></td>
        <td class="<?php echo $requirement[2] ? 'passed' : ($requirement[1]
            ? 'failed' : 'warning'); ?>">
            <?php echo $requirement[2] ? 'ОК' : ($requirement[1] ? 'Ошибка'
            : 'Предупреждение'); ?>
        </td>
        <td><?php echo $requirement[4]; ?></td>
    </tr>
    <?php endforeach;?>
</table>



<?php echo CHtml::beginForm(array('default/index'), 'get', array('style' => 'display:inline;')); ?>
<?php echo CHtml::submitButton('<<< Назад'); ?>
<?php echo CHtml::endForm(); ?>

<?php if ($result): ?>
<?php echo CHtml::beginForm(array('default/dbsettings'), 'get', array('style' => 'display:inline;')); ?>
<?php echo CHtml::submitButton('Продолжить >>>'); ?>
<?php echo CHtml::endForm(); ?>
<?php endif; ?>
    

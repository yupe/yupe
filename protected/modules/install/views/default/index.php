<?php if (!$result): ?>
    <div class="flash-error">
        <b><?php echo Yii::t('install', 'Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!'); ?></b>
    </div>
<?php endif; ?>

<table class="table table-striped">
    <tr>
        <th>Значение</th>
        <th>Результат</th>
        <th>Комментарий</th>
    </tr>
    <?php foreach ($requirements as $requirement): ?>
    <tr>
        <td style="width:200px;"><?php echo $requirement[0]; ?></td>
        <td>
            <?php echo $requirement[1] ? 'ОК' : 'Ошибка'; ?>
        </td>
        <td><?php echo $requirement[3]; ?></td>
    </tr>
    <?php endforeach;?>
</table>
<br /><br /><br />
<?php if ($result): ?>
    <?php echo CHtml::link('Далее', '/install/default/hello'); ?>
<?php endif; ?>
<br /><br /><br />
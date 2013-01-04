<?php if (!$result): ?>
    <div class="alert alert-block alert-error">
        <b><?php echo Yii::t('install', 'Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!'); ?></b>
    </div>
<?php endif; ?>

<table class="table table-striped">
    <tr>
        <th><?php echo Yii::t('install','Значение');?></th>
        <th><?php echo Yii::t('install','Результат');?></th>
        <th><?php echo Yii::t('install','Комментарий');?></th>
    </tr>
    <?php foreach ($requirements as $requirement): ?>
    <tr>
        <td style="width:200px;"><?php echo $requirement[0]; ?></td>
        <td>
            <?php $this->widget('bootstrap.widgets.TbLabel', array(
                'type'  => $requirement[1] ? 'success' : 'important',
                'label' => $requirement[1] ? 'ОК' : 'Ошибка',
            )); ?>
        </td>
        <td><?php echo $requirement[2]; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('install', '< Назад'),
    'url'   => array('/install/default/index'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'     => 'primary',
    'label'    => Yii::t('install', 'Продолжить >'),
    'disabled' => ($result) ? false : true,
) + (($result) ? array('url' => array('/install/default/requirements')) : array())); ?>
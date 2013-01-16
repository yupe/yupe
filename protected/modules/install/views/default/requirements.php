<?php if (!$result): ?>
    <div class="alert alert-block alert-error">
        <b><?php echo Yii::t('InstallModule.install', 'Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!'); ?></b>
    </div>
<?php endif; ?>

<div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'На данном этапе Юпи! проверяет версию PHP и наличие всех необходимых модулей.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Для продолжения установки все возникшие проблемы Вам необходимо исправить.'); ?></p>
</div>


<table class="table table-striped">
    <tr>
        <th><?php echo Yii::t('InstallModule.install','Значение');?></th>
        <th><?php echo Yii::t('InstallModule.install','Результат');?></th>
        <th><?php echo Yii::t('InstallModule.install','Комментарий');?></th>
    </tr>
    <?php foreach ($requirements as $requirement): ?>
    <tr>
        <td style="width:200px;"><?php echo $requirement[0]; ?></td>
        <td>
            <?php $this->widget('bootstrap.widgets.TbLabel', array(
                'type'  => $requirement[2] ? 'success' : ($requirement[1] ? 'important' : 'notice'),
                'label' => $requirement[2] ? 'ОК' : ($requirement[1] ? Yii::t('InstallModule.install','Ошибка') : Yii::t('InstallModule.install','Предупреждение')),
            )); ?>
        </td>
        <td><?php echo ($requirement[4] == '') ? '&nbsp;' : $requirement[4]; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('InstallModule.install', '< Назад'),
    'url'   => array('/install/default/environment'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'     => 'primary',
    'label'    => Yii::t('InstallModule.install', 'Продолжить >'),
    'disabled' => ($result) ? false : true,
) + (($result) ? array('url' => array('/install/default/dbsettings')) : array())); ?>
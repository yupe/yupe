<?php if (!$result): ?>
    <div class="alert alert-block alert-error">
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
            <?php $this->widget('bootstrap.widgets.TbLabel', array(
                'type'  => $requirement[2] ? 'success' : ($requirement[1] ? 'important' : 'important'),
                'label' => $requirement[2] ? 'ОК' : ($requirement[1] ? 'Ошибка' : 'Предупреждение'),
            )); ?>
        </td>
        <td><?php echo ($requirement[4] == '') ? '&nbsp;' : $requirement[4]; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'label' => Yii::t('install', '< Назад'),
    'url'   => array('/install/default/environment'),
)); ?>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'     => 'primary',
    'label'    => Yii::t('install', 'Продолжить >'),
    'disabled' => ($result) ? false : true,
) + (($result) ? array('url' => array('/install/default/dbsettings')) : array())); ?>
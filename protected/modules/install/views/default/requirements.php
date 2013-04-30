<?php
/**
 * Отображение для requirements:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
 ?>
<?php if (!$data['result']) : ?>
    <div class="alert alert-block alert-error">
        <b><?php echo Yii::t('InstallModule.install', 'Дальнейшая установка невозможна, пожалуйста, исправьте ошибки!'); ?></b>
    </div>
<?php endif; ?>

<div class="alert alert-block alert-info">
    <p><b><?php echo Yii::t('InstallModule.install','При возникновении проблем с установкой, пожалуйста, посетите вот эту {link} ветку форума!',array(
                    '{link}' => CHtml::link('http://yupe.ru/talk/viewforum.php?id=10','http://yupe.ru/talk/viewforum.php?id=10',array('target' => '_blank'))
                ));?></b></p>
</div>

<div class="alert alert-block alert-info">
        <p><?php echo Yii::t('InstallModule.install', 'На данном этапе Юпи! проверяет версию PHP и наличие всех необходимых модулей.'); ?></p>
        <p><?php echo Yii::t('InstallModule.install', 'Для продолжения установки все возникшие проблемы Вам необходимо исправить.'); ?></p>
</div>

<table class="table table-striped">
    <tr>
        <th><?php echo Yii::t('InstallModule.install', 'Значение');?></th>
        <th><?php echo Yii::t('InstallModule.install', 'Результат');?></th>
        <th><?php echo Yii::t('InstallModule.install', 'Комментарий');?></th>
    </tr>
    <?php foreach ($data['requirements'] as $requirement): ?>
    <tr>
        <td style="width:200px;"><?php echo $requirement[0]; ?></td>
        <td>
            <?php
            $this->widget(
                'bootstrap.widgets.TbLabel', array(
                    'type'  => $requirement[2] ? 'success' : ($requirement[1] ? 'important' : 'notice'),
                    'label' => $requirement[2] ? 'ОК' : ($requirement[1] ? Yii::t('InstallModule.install', 'Ошибка') : Yii::t('InstallModule.install', 'Предупреждение')),
                )
            ); ?>
        </td>
        <td><?php echo ($requirement[4] == '') ? '&nbsp;' : $requirement[4]; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'label' => Yii::t('InstallModule.install', '< Назад'),
        'url'   => array('/install/default/environment'),
    )
); ?>

<?php
if ($data['result'] !== false)

    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'  => 'primary',
            'label' => Yii::t('InstallModule.install', 'Продолжить >'),
            'url'   => array('/install/default/dbsettings'),
        )
    );

else
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'  => 'primary',
            'label' => Yii::t('InstallModule.install', 'Обновить'),
            'url'   => array('/install/default/requirements')
        )
    );
?>
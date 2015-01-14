<?php
/**
 * Отображение для requirements:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
?>
<?php if (!$data['result']) : { ?>
    <div class="alert alert-danger">
        <b><?php echo Yii::t('InstallModule.install', 'Install can\'t be continued. Please check errors!'); ?></b>
    </div>
<?php } endif; ?>

<?php $this->widget('install.widgets.GetHelpWidget'); ?>

<div class="alert alert-info">
    <p><?php echo Yii::t('InstallModule.install', 'Yupe checks PHP version and needed extensions on this step.'); ?></p>

    <p><?php echo Yii::t(
            'InstallModule.install',
            'To continue installation you need to repair error was occured.'
        ); ?></p>
</div>

<table class="table table-striped">
    <tr>
        <th><?php echo Yii::t('InstallModule.install', 'Value'); ?></th>
        <th><?php echo Yii::t('InstallModule.install', 'Result'); ?></th>
        <th><?php echo Yii::t('InstallModule.install', 'Comments'); ?></th>
    </tr>
    <?php foreach ($data['requirements'] as $requirement): { ?>
        <tr>
            <td style="width:200px;"><?php echo $requirement[0]; ?></td>
            <td>
                <?php
                $this->widget(
                    'bootstrap.widgets.TbLabel',
                    [
                        'context' => $requirement[2] ? 'success' : ($requirement[1] ? 'danger' : 'default'),
                        'label'   => $requirement[2] ? 'ОК' : ($requirement[1] ? Yii::t(
                                'InstallModule.install',
                                'Error'
                            ) : Yii::t('InstallModule.install', 'Warning')),
                    ]
                ); ?>
            </td>
            <td><?php echo ($requirement[4] == '') ? '&nbsp;' : $requirement[4]; ?></td>
        </tr>
    <?php } endforeach; ?>
</table>

<br/>

<?php echo CHtml::link(
    Yii::t('InstallModule.install', '< Back'),
    ['/install/default/environment'],
    ['class' => 'btn btn-default']
); ?>

<?php
if ($data['result'] !== false) {
    echo CHtml::link(
        Yii::t('InstallModule.install', 'Continue >'),
        ['/install/default/dbsettings'],
        ['class' => 'btn btn-primary']
    );
} else {
    echo CHtml::link(
        Yii::t('InstallModule.install', 'Refresh'),
        ['/install/default/requirements'],
        ['class' => 'btn btn-primary']
    );
}
?>

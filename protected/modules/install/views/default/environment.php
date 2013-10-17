<?php
/**
 * Отображение для environment:
 * 
 *   @category YupeView
 *   @package  yupe
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
?>
<?php if (!$data['result']) : ?>
    <div class="alert alert-block alert-error">
        <b><?php echo Yii::t('InstallModule.install', 'Install can\'t be continued. Please check errors!'); ?></b>
    </div>
<?php endif; ?>

<?php $this->widget('install.widgets.GetHelpWidget');?>

<div class="alert alert-block alert-info">
    <p><?php echo Yii::t('InstallModule.install', 'On this step Yupe checks access right for needed directories.'); ?></p>
    <p><?php echo Yii::t('InstallModule.install', 'To continue installation you need to repair error was occured.'); ?></p>
</div>

<table class="table table-striped">
    <tr>
        <th><?php echo Yii::t('InstallModule.install', 'Value');?></th>
        <th><?php echo Yii::t('InstallModule.install', 'Result');?></th>
        <th><?php echo Yii::t('InstallModule.install', 'Comments');?></th>
    </tr>
    <?php foreach ($data['requirements'] as $requirement): ?>
    <tr>
        <td style="width:200px;"><?php echo $requirement[0]; ?></td>
        <td>
            <?php
            $this->widget(
                'bootstrap.widgets.TbLabel', array(
                    'type'  => $requirement[1] ? 'success' : 'important',
                    'label' => $requirement[1] ? 'ОК' : Yii::t('InstallModule.install', 'Error'),
                )
            ); ?>
        </td>
        <td><?php echo $requirement[2]; ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php $this->widget(
    'bootstrap.widgets.TbButton', array(
        'label' => Yii::t('InstallModule.install', '< Back'),
        'url'   => array('/install/default/index'),
    )
); ?>

<?php
if ($data['result'] !== false)

    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'  => 'primary',
            'label' => Yii::t('InstallModule.install', 'Continue >'),
            'url'   => array('/install/default/requirements'),
        )
    );

else
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'  => 'primary',
            'label' => Yii::t('InstallModule.install', 'Refresh'),
            'url'   => array('/install/default/environment')
        )
    );
?>

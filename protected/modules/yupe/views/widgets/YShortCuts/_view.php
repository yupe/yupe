<?php
/**
 * @var $module \yupe\components\WebModule
 * @var $updates array
 */
?>
<div class="cn">
    <i class="shortcut-icon <?= CHtml::encode($module->getIcon()); ?>"></i>
    <span class="shortcut-label"><?= CHtml::encode($module->getName()); ?></span>
    <?php if (Yii::app()->getUser()->isSuperUser()): ?>
        <?php if ($module->isConfigNeedUpdate()): ?>
            <span class='label label-warning config-update' data-module="<?= $module->getId(); ?>"
                  data-toggle="tooltip" data-placement="top"
                  title="<?= Yii::t('YupeModule.yupe', 'Apply new configuration'); ?>"><i
                    class='fa fa-fw fa-refresh'></i></span>
        <?php endif; ?>
        <?php if (!empty($updates[$module->getId()])): ?>
            <span class='label label-danger' data-toggle="tooltip" data-placement="top"
                  title="<?= Yii::t('YupeModule.yupe', 'Apply new migrations'); ?>"><i
                    class='fa fa-fw fa-refresh'></i><?= count($updates[$module->getId()]); ?></span>
        <?php endif; ?>
    <?php endif; ?>
</div>

<?php
$this->breadcrumbs = array(
    Yii::t('YupeModule.yupe', 'System') => array('settings'),
    Yii::t('YupeModule.yupe', 'Modules'),
);
?>

<h1><?php echo Yii::t('YupeModule.yupe', 'Module Settings'); ?></h1>

<?php echo Yii::t('YupeModule.yupe', 'Setup modules "{app}" for your needs', array('{app}' => Yii::app()->name)); ?>

<br/><br/>
<div class="alert">
    <p>
        <?php
            $yupeCount = count($modules);
            $enableCount = 0;
            foreach ($modules as $module) {
                if ($module instanceof yupe\components\WebModule && ($module->getIsActive() || $module->getIsNoDisable()))
                    $enableCount++;
            }
        ?>
        <?php echo Yii::t('YupeModule.yupe', 'Installed'); ?>
        <small class="label label-info"><?php echo $yupeCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'module|module|modules', $yupeCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'enabled'); ?>
        <small class="label label-info"><?php echo $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'module|module|modules', $enableCount); ?>,
        <?php echo Yii::t('YupeModule.yupe', 'disabled|disabled',$yupeCount - $enableCount); ?>
        <small class="label label-info"><?php echo $yupeCount - $enableCount; ?></small>
        <?php echo Yii::t('YupeModule.yupe', 'module|module|modules', $yupeCount - $enableCount); ?>
        <br/>
        <small>
            <?php echo Yii::t('YupeModule.yupe', '( You always can find another modules on {link} or {order_link} )', array(
                '{link}'       => CHtml::link(Yii::t('YupeModule.yupe', 'official site'), 'http://yupe.ru/?from=mlist', array('target' => '_blank')),
                '{order_link}' => CHtml::link(Yii::t('YupeModule.yupe', 'order to develop them'), 'http://yupe.ru/contacts?from=mlist', array('target' => '_blank')),
            )); ?>
        </small>
    </p>
</div>

<?php echo $this->renderPartial('_moduleslist', array('modules' => $modules)); ?>
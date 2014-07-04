<div class="page-header">
    <h1><?php echo Yii::t('YupeModule.yupe', 'Control panel "{app}"', array('{app}' => CHtml::encode(Yii::t('YupeModule.yupe', Yii::app()->name)))); ?><br/></h1>
</div>

<?php foreach ($modules as $module): ?>
    <?php  if ($module instanceof yupe\components\WebModule === false):?>
        <?php continue; ?>
    <?php endif; ?>
    <?php if ($module->getIsActive()): ?>
        <?php $messages = $module->checkSelf(); ?>
        <?php if (is_array($messages)): ?>
            <?php foreach ($messages as $key => $value): ?>
                <?php if (!is_array($value)) continue; ?>
                <div class="accordion module-errors-accordion" id="accordion<?php echo $module->getId(); ?>">
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <a  class="accordion-toggle"
                                data-toggle="collapse"
                                data-parent="#accordion<?php echo $module->getId(); ?>"
                                href="#collapse<?php echo $module->getId(); ?>"
                                >
                                <?php echo Yii::t('YupeModule.yupe', 'Module {icon} "{module}", messages: {count}', array(
                                        '{icon}'   => $module->icon ? "<i class='icon-" . $module->icon . "'>&nbsp;</i> " : "",
                                        '{module}' => $module->getName(),
                                        '{count}'  => '<small class="label label-warning">' . count($value) . '</small>',
                                    )); ?>
                            </a>
                        </div>
                        <div id="collapse<?php echo $module->getId(); ?>" class="accordion-body collapse">
                            <?php foreach ($value as $error): ?>
                                <div class="accordion-inner">
                                    <div class="alert alert-<?php echo $error['type']; ?>">
                                        <h4 class="alert-heading">
                                            <?php echo Yii::t('YupeModule.yupe', 'Module "{module} ({id})"', array(
                                                    '{module}' => $module->name,
                                                    '{id}'     => $module->getId(),
                                                )); ?>
                                        </h4>
                                        <?php echo $error['message']; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php endforeach; ?>

<?php foreach ($modules as $module): ?>
    <?php  if ($module instanceof yupe\components\WebModule === false):?>
        <?php continue; ?>
    <?php endif; ?>

    <?php if ($module->getIsActive()): ?>
        <?php echo $module->getPanelWidget(); ?>
    <?php endif;?>

<?php endforeach;?>


<legend><?php echo Yii::t('YupeModule.yupe', 'Fast access to modules'); ?> </legend>

<?php
$this->widget(
    'yupe\widgets\YShortCuts', array(
        'shortcuts' => $modulesNavigation,
        'modules'   => $modules,
        'updates'   => Yii::app()->migrator->checkForUpdates($modules),
    )
); ?>
<?php $this->menu = $modulesNavigation; ?>
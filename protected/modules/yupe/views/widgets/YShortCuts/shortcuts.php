<div class="shortcuts">
    <?php foreach ($modules as $module): ?>
        <?php if(!$module->getIsShowInAdminMenu() && !$module->getExtendedNavigation()):?>
            <?php continue;?>
        <?php endif;?>
        <a class="shortcut" href="<?php echo Yii::app()->createAbsoluteUrl($module->getAdminPageLink()); ?>">
            <div class="cn">
                <i class="shortcut-icon <?php echo $module->getIcon(); ?>"></i>
                <span class="shortcut-label"><?php echo $module->getName(); ?></span>
                <?php if (Yii::app()->getUser()->isSuperUser()): ?>
                    <?php if ($module->isConfigNeedUpdate()): ?>
                        <span class='label label-warning config-update' data-module="<?php echo $module->getId(); ?>"
                              data-toggle="tooltip" data-placement="top"
                              title="<?php echo Yii::t('YupeModule.yupe', 'Apply new configuration'); ?>"><i
                                class='fa fa-fw fa-refresh'></i></span>
                    <?php endif; ?>
                    <?php if (!empty($updates[$module->getId()])): ?>
                        <span class='label label-danger' data-toggle="tooltip" data-placement="top"
                              title="<?php echo Yii::t('YupeModule.yupe', 'Apply new migrations'); ?>"><i
                                class='fa fa-fw fa-refresh'></i><?php echo count($updates[$module->getId()]); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </a>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.config-update').on('click', function (event) {
            var $this = $(this);
            event.preventDefault();
            $.post('<?php echo Yii::app()->createUrl('/yupe/modulesBackend/configUpdate/')?>', {
                '<?php echo Yii::app()->getRequest()->csrfTokenName;?>': '<?php echo Yii::app()->getRequest()->csrfToken;?>',
                'module': $(this).data('module')
            }, function (response) {

                if (response.result) {
                    $this.fadeOut();
                    $('#notifications').notify({
                        message: { text: '<?php echo Yii::t('YupeModule.yupe','Successful');?>' },
                        type: 'success'
                    }).show();
                }

            }, 'json');
        });
    });
</script>

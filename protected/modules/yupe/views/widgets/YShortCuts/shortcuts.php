<?php
/**
 * @var $this \yupe\widgets\YShortCuts
 * @var $modules \yupe\components\WebModule[]
 * @var $updates array
 */
?>
<div class="shortcuts">
    <?php foreach ($modules as $module): ?>
        <?php if (!$module->getIsShowInAdminMenu() && !$module->getExtendedNavigation()): ?>
            <?php continue; ?>
        <?php endif; ?>
        <?php echo CHtml::link($this->render('_view', ['module' => $module, 'updates' => $updates], true), is_string($module->getAdminPageLink()) ? [$module->getAdminPageLink()] : $module->getAdminPageLink(), ['class' => 'shortcut']); ?>
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
                        message: {text: '<?php echo Yii::t('YupeModule.yupe','Successful');?>'},
                        type: 'success'
                    }).show();
                }

            }, 'json');
        });
    });
</script>

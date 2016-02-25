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
        <?=  CHtml::link($this->render('_view', ['module' => $module, 'updates' => $updates], true), is_string($module->getAdminPageLink()) ? [$module->getAdminPageLink()] : $module->getAdminPageLink(), ['class' => 'shortcut']); ?>
    <?php endforeach; ?>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('.config-update').on('click', function (event) {
            var $this = $(this);
            event.preventDefault();
            $.post('<?=  Yii::app()->createUrl('/yupe/modulesBackend/configUpdate/')?>', {
                '<?=  Yii::app()->getRequest()->csrfTokenName;?>': '<?=  Yii::app()->getRequest()->csrfToken;?>',
                'module': $(this).data('module')
            }, function (response) {

                if (response.result) {
                    $this.fadeOut();
                    $('#notifications').notify({
                        message: {text: '<?=  Yii::t('YupeModule.yupe','Successful');?>'},
                        type: 'success'
                    }).show();
                }

            }, 'json');
        });
    });
</script>

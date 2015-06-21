<?php $this->beginContent($this->yupe->getBackendLayoutAlias("main")); ?>
<div class="row">
    <div class="col-sm-3 col-lg-2">
        <div class="panel panel-default" style="padding: 8px 0;">
            <?php $this->widget('yupe\widgets\YAdminMenu'); ?>
        </div>
        <div class="panel panel-default" style="padding: 8px;"><?php $this->widget('yupe\widgets\YModuleInfo'); ?></div>
    </div>

    <div class="col-sm-9 col-lg-10">
        <?php
        if (count($this->breadcrumbs)) {
            $this->widget(
                'bootstrap.widgets.TbBreadcrumbs',
                [
                    'homeLink' => CHtml::link(Yii::t('YupeModule.yupe', 'Home'), ['/yupe/backend/index']),
                    'links'    => $this->breadcrumbs,
                ]
            );
        }
        ?>
        <!-- breadcrumbs -->
        <?php $this->widget('bootstrap.widgets.TbAlert'); ?>
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>

</div>
<?php $this->endContent(); ?>

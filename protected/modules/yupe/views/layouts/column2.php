<?php $this->beginContent($this->yupe->getBackendLayoutAlias("main")); ?>
<div class="row">
    <div class="<?php echo $this->hideSidebar ? 'col-sm-12' : 'col-sm-12 col-md-9 col-lg-10'; ?>">
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
    <div class="<?php echo $this->hideSidebar ? 'hidden' : 'col-md-3 col-lg-2 hidden-xs hidden-sm'; ?>">
        <?php if (count($this->menu)): ?>
            <div class="panel panel-default" style="padding: 8px 0;">
                <?php $this->widget(
                    'bootstrap.widgets.TbMenu',
                    [
                        'type'  => 'list',
                        'items' => $this->yupe->getSubMenu($this->menu),
                    ]
                ); ?>
            </div>
        <?php endif; ?>
        <div class="panel panel-default" style="padding: 8px;"><?php $this->widget('yupe\widgets\YModuleInfo'); ?></div>
    </div>
</div>
<?php $this->endContent(); ?>

<?php $this->beginContent($this->yupe->getBackendLayoutAlias("main")); ?>
<div class="row">
    <div class="<?php echo $this->hideSidebar ? 'col-sm-12' : 'col-sm-10'; ?>">
        <?php
        if (count($this->breadcrumbs)) {
            $this->widget(
                'bootstrap.widgets.TbBreadcrumbs',
                array(
                    'homeLink' => CHtml::link(Yii::t('YupeModule.yupe', 'Home'), array('/yupe/backend/index')),
                    'links'    => $this->breadcrumbs,
                )
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
    <div class="<?php echo $this->hideSidebar ? 'hidden' : 'col-sm-2'; ?>">
        <?php if (count($this->menu)): { ?>
            <div class="panel panel-default" style="padding: 8px 0;">
                <?php $this->widget(
                    'bootstrap.widgets.TbMenu',
                    array(
                        'type'  => 'list',
                        'items' => $this->yupe->getSubMenu($this->menu),
                    )
                ); ?>
            </div>
        <?php } endif; ?>
        <div class="panel panel-default" style="padding: 8px;"><?php $this->widget('yupe\widgets\YModuleInfo'); ?></div>
    </div>
</div>
<?php $this->endContent(); ?>

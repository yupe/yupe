<?php $this->beginContent(Yii::app()->controller->module->getLayoutAlias()); ?>
    <div class="span9 well">
        <?php if (count($this->breadcrumbs))
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
        ?><!-- breadcrumbs -->
        <?php $this->widget('YFlashMessages'); ?>
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="span3 installMenu">
        <div class="well" style="padding: 8px 0;">
        <?php
        $this->widget(
            'bootstrap.widgets.TbMenu', array(
                'type'  =>'list',
                'items' => Yii::app()->controller->module->getInstallMenu(),
            )
        );?>
        </div>
    </div>
<?php $this->endContent(); ?>
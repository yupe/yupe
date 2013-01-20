<?php $this->beginContent(Yii::app()->controller->module->getLayoutAlias()); ?>
<?php Yii::app()->clientScript->registerCssFile('/css/install.css'); ?>
    <div class="container" id="page">
        <div class="span11 well">
            <?php if (count($this->breadcrumbs))
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
            ?><!-- breadcrumbs -->
            <?php $this->widget('YFlashMessages'); ?>
            <div id="content">
                <?php echo $content; ?>
            </div>
            <!-- content -->
        </div>
    </div>
    <div class="span2 installMenu">
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
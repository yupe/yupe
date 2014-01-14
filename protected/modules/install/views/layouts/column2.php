<?php $this->beginContent(Yii::app()->controller->module->getLayoutAlias()); ?>
    <div class="span9 well">
        <?php if (count($this->breadcrumbs))
            $this->widget('bootstrap.widgets.TbBreadcrumbs', array('links' => $this->breadcrumbs));
        ?><!-- breadcrumbs -->
        <?php //$this->widget('yupe\widgets\YFlashMessages'); ?>
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
        <div class="alert alert-notice">
            <strong><?php echo Yii::app()->name;?></strong> разрабатывается <a href="https://github.com/yupe/yupe/graphs/contributors" target="_blank">сообществом</a> при моральной поддержке <?php echo CHtml::link('amyLabs','http://amylabs.ru', array('target' => '_blank'));?>!
            <strong><?php echo CHtml::link('Напишите нам', 'http://amylabs.ru/contact')?></strong> при возникновении проблем!
        </div>
    </div>
<?php $this->endContent(); ?>
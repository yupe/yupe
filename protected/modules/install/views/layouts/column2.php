<?php $this->beginContent(Yii::app()->controller->module->getLayoutAlias()); ?>
<div class="row">
    <div class="col-sm-9 well">
        <?php if (count($this->breadcrumbs)) {
            $this->widget('bootstrap.widgets.TbBreadcrumbs', ['links' => $this->breadcrumbs]);
        }
        ?><!-- breadcrumbs -->
        <?php //$this->widget('yupe\widgets\YFlashMessages'); ?>
        <div id="content">
            <?= $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="col-sm-3">
        <div>
            <?php
            $this->widget(
                'bootstrap.widgets.TbMenu',
                [
                    'type' => 'list',
                    'items' => Yii::app()->controller->module->getInstallMenu(),
                    'htmlOptions' => ['class' => 'well']
                ]
            );?>
        </div>
        <div class="alert alert-warning">
            <strong><?= Yii::app()->name; ?></strong> разрабатывается
            <a href="https://github.com/yupe/yupe/graphs/contributors" target="_blank">сообществом</a> при
            поддержке <?= CHtml::link(
                'amylabs',
                'http://amylabs.ru?from=yupe-install',
                ['target' => '_blank']
            ); ?>!
            <strong><?= CHtml::link('Напишите нам', 'http://amylabs.ru/contact') ?></strong> при возникновении
            проблем!
        </div>
        
    </div>
</div>
<?php $this->endContent(); ?>

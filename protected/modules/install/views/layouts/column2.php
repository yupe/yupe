<?php $installAssets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.install.views.assets')); ?>
<?php $this->beginContent(Yii::app()->controller->module->getLayoutAlias()); ?>
<div class="row">
    <div class="col-sm-9 well">
        <?php if (count($this->breadcrumbs)) {
            $this->widget('bootstrap.widgets.TbBreadcrumbs', ['links' => $this->breadcrumbs]);
        }
        ?>
        <div id="content">
            <?= $content; ?>
        </div>
    </div>
    <div class="col-sm-3">
        <div>
            <?php
            $this->widget(
                'bootstrap.widgets.TbMenu',
                [
                    'type' => 'list',
                    'items' => Yii::app()->controller->module->getInstallMenu(),
                    'htmlOptions' => ['class' => 'well'],
                ]
            ); ?>
        </div>
        <div>
            <iframe src="http://yupe.ru/info/install?version=<?= $this->yupe->getVersion();?>&lang=<?= Yii::app()->language;?>" scrolling="no" id="yupestore"></iframe>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>

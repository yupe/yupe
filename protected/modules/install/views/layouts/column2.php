<?php $installAssets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.install.views.assets')); ?>
<?php $this->beginContent(Yii::app()->getController()->getModule()->getLayoutAlias()); ?>
<div class="row">
    <div class="col-sm-3">
        <div>
            <?php
            $this->widget(
                'bootstrap.widgets.TbMenu',
                [
                    'type' => 'list',
                    'items' => Yii::app()->getController()->getModule()->getInstallMenu(),
                    'htmlOptions' => ['class' => 'well'],
                ]
            ); ?>
        </div>
    </div>
    <div class="col-sm-6 well">
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
            <a class="btn btn-success" target="_blank" href="http://yupe.ru/make-world-better?from=install" style="width: 300px;"><?= Yii::t('InstallModule.install', 'Donate!');?></a>
        </div>
        <br/>
        <div>
            <iframe src="http://yupe.ru/info/install?version=<?= $this->yupe->getVersion();?>&lang=<?= Yii::app()->getLanguage();?>" scrolling="no" id="yupestore"></iframe>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>

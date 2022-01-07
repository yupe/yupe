<?php $installAssets = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.modules.install.views.assets')); ?>
<?php $this->beginContent(Yii::app()->getController()->getModule()->getLayoutAlias()); ?>
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
            <a class="btn btn-success banner-width" style="width: 100%;" target="_blank" href="https://sobe.ru/na/yupi">Сказать спасибо!</a>
            <br/><br/>
        </div>

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
        <div>
            <iframe src="https://yupe.ru/info/install?version=<?= $this->yupe->getVersion();?>&lang=<?= Yii::app()->getLanguage();?>" scrolling="no" id="yupestore"></iframe>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>

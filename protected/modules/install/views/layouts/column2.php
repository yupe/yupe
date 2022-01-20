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
            <a class="btn btn-success banner-width" style="width: 100%;" target="_blank" href="https://sobe.ru/na/yupi">Сказать
                спасибо!</a>
        </div>
        <br/><br/>
        <div>
            <a target="_new" href="https://timeweb.com/ru/?i=28284&a=125"><img style="border:0px;"
                                                                               src="https://wm.timeweb.ru/images/posters/300x250/300x250-9-anim.gif"></a>
        </div>
        <br/><br/>
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
</div>
<?php $this->endContent(); ?>

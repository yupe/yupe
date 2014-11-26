<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="span-19">
        <div id="content">
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="span-5 last">
        <div id="sidebar">
            <?php
            $this->beginWidget('zii.widgets.CPortlet', ['title' => Yii::t('default', 'Actions')]);
            $this->widget(
                'zii.widgets.CMenu',
                [
                    'items'       => $this->menu,
                    'htmlOptions' => ['class' => 'operations'],
                ]
            );
            $this->endWidget();
            ?>
        </div>
        <!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>

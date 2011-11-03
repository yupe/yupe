<?php $this->beginContent('application.modules.yupe.views.layouts.main'); ?>
<div class="container">
    <div class="span-19">
        <?php $this->widget('YFlashMessages');?>
        <div id="content">            
            <?php echo $content; ?>
        </div>
        <!-- content -->
    </div>
    <div class="span-5 last">
        <div id="sidebar">
            <?php
            $this->beginWidget('zii.widgets.CPortlet', array(
                                                            'title' => Yii::t('page', 'Основное меню'),
                                                        ));
            $this->widget('zii.widgets.CMenu', array(
                                                    'items' => $this->menu,
                                                    'htmlOptions' => array('class' => 'operations'),
                                               ));
            $this->endWidget();
            ?>
        </div>
        <!-- sidebar -->
    </div>
</div>
<?php $this->endContent(); ?>

<div class="shortcuts">
    <?php foreach($modules as $module):?>
        <a class="shortcut" href="<?php echo Yii::app()->createAbsoluteUrl($module->getAdminPageLink());?>">
            <div class="cn">
                <i class="shortcut-icon <?php echo $module->getIcon();?>"></i>
                <span class="shortcut-label"><?php echo $module->getName();?></span>
                <?php if($module->isConfigNeedUpdate()):?>
                    <span class='label label-warning'  data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('YupeModule.yupe','Available new configuration');?>"><i class='glyphicon glyphicon-refresh pull-left'></i></span>
                <?php endif;?>
                <?php if(!empty($updates[$module->getId()])):?>
                    <span class='label label-danger'  data-toggle="tooltip" data-placement="top" title="<?php echo Yii::t('YupeModule.yupe','Apply new migrations');?>"><i class='glyphicon glyphicon-refresh'></i><?php echo count($updates[$module->getId()]);?></span>
                <?php endif;?>
            </div>
        </a>
    <?php endforeach;?>
</div>
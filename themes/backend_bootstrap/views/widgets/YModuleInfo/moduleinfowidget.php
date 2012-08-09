<button class="btn btn-small dropdown-toggle"
    title="<?php echo Yii::t('yupe', 'Информация о модуле'); ?>"
    data-toggle="collapse"
    data-target="#module-info-collapse-<?php echo $module->id; ?>"
>
    <?php
    // @TODO: В случае, если это не бутстраповская иконка - выводить бекграундом
    ?>
    <?php if ( $module->icon ) echo "<i class='icon-".$module->icon."'> </i> "; ?>
    <span class="label label-info" title="<?php echo Yii::t('yupe', 'версия'); ?>"><?php echo $module->getVersion(); ?></span> <?php echo $module->getName(); ?>
    <span class="caret"></span>
</button>
<div id="module-info-collapse-<?php echo $module->id; ?>" class="collapse out">
<br />
<?php echo $module->getDescription(); ?><br/><br/>
<table class="table">
    <tr><td><?php echo Yii::t('yupe', 'Автор'); ?>:</td><td><?php echo CHtml::mailto($module->getAuthor(), $module->getAuthorEmail()); ?></td></tr>
    <tr><td><?php echo Yii::t('yupe', 'Сайт'); ?>:</td><td><?php echo CHtml::link($module->getUrl(), $module->getUrl()); ?></td></tr>
</table>
</div>

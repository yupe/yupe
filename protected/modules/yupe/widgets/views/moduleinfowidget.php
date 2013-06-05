<button class="btn btn-small dropdown-toggle" title="<?php echo Yii::t('YupeModule.yupe', 'Информация о модуле'); ?>"
        data-toggle="collapse" data-target="#module-info-collapse-<?php echo $module->getId(); ?>">
    <?php
    // @TODO: В случае, если это не бутстраповская иконка - выводить бекграундом
    if ($module->icon)
        echo '<i class="icon-' . $module->icon. '"><!-- icon --></i>';
    ?>
    <span class="label label-info" title="<?php echo Yii::t('YupeModule.yupe', 'версия'); ?>"><?php echo $module->version; ?></span>
    <?php echo $module->name; ?>
    <span class="caret"></span>
</button>
<div id="module-info-collapse-<?php echo $module->getId(); ?>" class="collapse out">
    <br />
    <?php echo $module->description; ?><br/><br/>
    <table class="table">
        <tr>
            <td><?php echo Yii::t('YupeModule.yupe', 'Автор'); ?>:</td>
            <td><?php echo CHtml::mailto($module->author, $module->authorEmail); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('YupeModule.yupe', 'Сайт'); ?>:</td>
            <td><?php echo CHtml::link($module->url, $module->url); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('YupeModule.yupe', 'Документация'); ?>:</td>
            <td><?php echo CHtml::link(Yii::t('YupeModule.yupe', 'читать на сайте'), "http://yupe.ru/docs/{$module->id}/index.html?from=modinfowidget",array('target' => '_blank')); ?></td>
        </tr>
    </table>
</div>

<button class="btn btn-small dropdown-toggle" title="<?php echo Yii::t('YupeModule.yupe', 'About module'); ?>"
        data-toggle="collapse" data-target="#module-info-collapse-<?php echo $module->getId(); ?>">
    <?php
    // @TODO: В случае, если это не бутстраповская иконка - выводить бекграундом
    if ($module->icon) {
        echo '<i class="' . $module->icon . '"></i>';
    }
    ?>
    <span class="label label-info"
          title="<?php echo Yii::t('YupeModule.yupe', 'version'); ?>"><?php echo $module->version; ?></span>
    <?php echo $module->name; ?>
    <span class="caret"></span>
</button>
<div id="module-info-collapse-<?php echo $module->getId(); ?>" class="collapse out">
    <br/>
    <?php echo $module->description; ?><br/><br/>
    <table class="table">
        <tr>
            <td><?php echo Yii::t('YupeModule.yupe', 'Author'); ?>:</td>
            <td><?php echo CHtml::mailto($module->author, $module->authorEmail); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('YupeModule.yupe', 'Web-site'); ?>:</td>
            <td><?php echo CHtml::link($module->url, $module->url); ?></td>
        </tr>
        <tr>
            <td><?php echo Yii::t('YupeModule.yupe', 'Docs'); ?>:</td>
            <td><?php echo CHtml::link(
                    Yii::t('YupeModule.yupe', 'read on site'),
                    "http://yupe.ru/docs/{$module->id}/index.html?from=modinfowidget",
                    array('target' => '_blank')
                ); ?></td>
        </tr>
    </table>
</div>

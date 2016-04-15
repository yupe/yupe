<button class="btn btn-small dropdown-toggle" title="<?= Yii::t('YupeModule.yupe', 'About module'); ?>"
        data-toggle="collapse" data-target="#module-info-collapse-<?= $module->getId(); ?>">
    <i class=" <?= $module->icon; ?> "></i>
    <span class="label label-info"
          title="<?= Yii::t('YupeModule.yupe', 'version'); ?>"><?= $module->version; ?></span>
    <?= $module->name; ?>
    <span class="caret"></span>
</button>
<div id="module-info-collapse-<?= $module->getId(); ?>" class="collapse out">
    <br/>
    <?= $module->description; ?><br/><br/>
    <table class="table">
        <tr>
            <td>
                <?= Yii::t('YupeModule.yupe', 'Author'); ?>:
                <?= CHtml::mailto($module->author, $module->authorEmail); ?>
            </td>
        </tr>
        <tr>
            <td>
                <?= Yii::t('YupeModule.yupe', 'Web-site'); ?>:
                <?= CHtml::link($module->url, $module->url, ['target' => '_blank']); ?>
            </td>
        </tr>
    </table>
</div>

<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Система') => array('settings'),
    Yii::t('yupe', 'Настройки модулей'),
);
?>

<h1><?php echo Yii::t('yupe', 'Настройки модулей'); ?></h1>

<?php echo Yii::t('yupe', 'Настройте модули "{app}" под Ваши потребности', array('{app}' => Yii::app()->name)); ?>

<br/><br/>

<p><?php echo Yii::t('yupe', 'Установлено');?>
    <b><?php echo $mn = count($modules); ?></b>
    <?php echo Yii::t('yupe', 'модуль|модуля|модулей', $mn); ?>.
</p>

<?php if (count($modules)): ?>
    <div class="page-header">
    <h6><?php echo Yii::t('yupe', 'Модули разработанные специально для "{app}" ', array('{app}' => CHtml::encode(Yii::app()->name))); ?></h6>
    </div>
    <table class="table table-striped table-vmiddle">
        <thead>
        <tr>
            <th></th>
            <th style="width: 32px;"><?php echo Yii::t('yupe', 'Версия'); ?></th>
            <th style="width: 32px;"></th>
            <th style="width: 150px;"><?php echo Yii::t('yupe', 'Название'); ?></th>
            <th><?php echo Yii::t('yupe', 'Описание'); ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php foreach ($modules as $module): ?>
                <?php $style = is_array($module->checkSelf()) ? "style='background-color:#FBC2C4;'" : ''; ?>
                <tr>
                    <td><?php echo ($module->icon ? ("<i class='icon-" . $module->icon . "'> </i> ") : ""); ?></td>
                    <td>
                        <small class='label <?php
                            $v = $module->version;
                            echo (($n = strpos($v, "(dev)")) !== FALSE)
                            ? "label-warning' title='" . Yii::t('yupe', 'Модуль в разработке') . "'>" . substr($v, 0, $n)
                            : "'>" . $v;
                        ?></small>
                    </td>
                    <td>
                        <?php if ($module->isMultiLang()): ?>
                            <i class="icon-globe" title="<?php echo Yii::t('yupe', 'Модуль мультиязычный'); ?>"></i>
                        <?php endif; ?>
                    </td>
                    <td>
                        <small style="font-size: 80%;"><?php echo $module->category; ?></small><br />
                        <?php echo CHtml::link($module->name, $module->adminPageLinkNormalize); ?>
                    </td>
                    <td>
                        <?php echo $module->description; ?>
                        <br />
                        <small style="font-size: 80%;"> <?php echo "<b>" . Yii::t('yupe', "Автор:") . "</b> " . $module->author; ?>
                        (<a href="mailto:<?php echo $module->authorEmail; ?>"><?php echo $module->authorEmail; ?></a>) &nbsp;
                        <?php echo "<b>" . Yii::t('yupe', "Сайт модуля:") . "</b> " . CHtml::link($module->url, $module->url); ?></small><br />
                    </td>
                    <td>
                        <?php if ($module->editableParams): ?>
                            <?php echo CHtml::link('<i class="icon-wrench" title="' . Yii::t('yupe', 'Настройки') . '"> </i>', array(
                                '/yupe/backend/modulesettings/',
                                'module' => $module->id,
                            )); ?>
                        <?php endif;?>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
<?php endif; ?>
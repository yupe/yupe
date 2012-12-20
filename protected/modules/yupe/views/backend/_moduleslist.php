<?php if (count($modules)): ?>
    <div class="page-header">
    <h6>
        <?php echo Yii::t('yupe', 'Модули разработанные специально для "{app}"', array(
            '{app}' => CHtml::encode(Yii::app()->name),
        )); ?>
    </h6>
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
                <tr <?php echo is_array($module->checkSelf()) ? "style='background-color:#FBC2C4;'" : '';?>>
                    <td><?php echo ($module->icon ? ("<i class='icon-" . $module->icon . "'>&nbsp;</i> ") : ""); ?></td>
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
                        <?php if ($module->isStatus || $module->isNoDisable): ?>
                            <?php echo CHtml::link($module->name, $module->adminPageLinkNormalize); ?>
                        <?php else: ?>
                            <span><?php echo $module->name; ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php echo $module->description; ?>
                        <br />
                        <small style="font-size: 80%;"> <?php echo "<b>" . Yii::t('yupe', "Автор:") . "</b> " . $module->author; ?>
                        (<a href="mailto:<?php echo $module->authorEmail; ?>"><?php echo $module->authorEmail; ?></a>) &nbsp;
                        <?php echo "<b>" . Yii::t('yupe', 'Сайт модуля:') . "</b> " . CHtml::link($module->url, $module->url); ?></small><br />
                    </td>
                    <td>
                        <?php if ($module->editableParams && ($module->isStatus || $module->isNoDisable)): ?>
                            <?php echo CHtml::link('<i class="icon-wrench" title="' . Yii::t('yupe', 'Настройки') . '">&nbsp;</i>', array(
                                '/yupe/backend/modulesettings/',
                                'module' => $module->id,
                            )); ?>
                        <?php endif;?>
                        <?php
                        $url = array('/yupe/backend/modulechange/', 'name' => $module->id);
                        echo !$module->isNoDisable
                            ? ($module->isStatus
                                ? CHtml::link('<i class="icon-remove-circle" title="' . Yii::t('yupe', 'Выключить') . '">&nbsp;</i>', $url + array('status' => '0'))
                                : CHtml::link('<i class="icon-ok-sign" title="' . Yii::t('yupe', 'Включить') . '">&nbsp;</i>', $url + array('status' => '1'))
                            )
                            : '';
                        ?>
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>
<?php endif; ?>

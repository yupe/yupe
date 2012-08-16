<div class="page-header">
    <h1><?php echo Yii::t('yupe', 'Панель управления "{app}"', array('{app}' => CHtml::encode(Yii::app()->name))); ?><br/>
    <small><?php echo Yii::t('yupe', 'Добро пожаловать в панель управления Вашим сайтом!'); ?></small></h1>
</div>

<?php foreach ($modules as $module): ?>
<?php if (is_array($module->checkSelf())): ?>
    <?php $error = $module->checkSelf(); ?>
    <div class="alert alert-<?php echo $error['type']; ?>">
        <h4 class="alert-heading">
            <?php echo Yii::t('yupe', 'Модуль "{module} ({id})"', array(
                '{module}' => $module->name,
                '{id}'     => $module->id,
            )); ?>
        </h4>
        <?php echo $error['message'];?>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<p><?php echo Yii::t('yupe','Вы используете Yii версии'); ?>
    <b><?php echo Yii::getVersion(); ?></b>, <?php echo CHtml::encode(Yii::app()->name); ?>
    версии <b><?php echo Yii::app()->getModule('yupe')->version; ?></b>,
    php <?php echo Yii::t('yupe', 'версии'); ?>
    <b><?php echo phpversion(); ?></b></p>

<p><?php echo Yii::t('yupe', 'Установлено');?>
    <b><?php echo $mn = count($modules) + count($yiiModules); ?></b>
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

<?php if (count($yiiModules)): ?>
    <br />
    <div class="page-header">
        <h6><?php echo Yii::t('yupe', 'Yii модули'); ?></h6>
    </div>
    <table  class="table table-striped">
        <thead>
            <tr>
                <th><?php echo Yii::t('yupe', 'id'); ?></th>
                <th><?php echo Yii::t('yupe', 'Название'); ?></th>
                <th><?php echo Yii::t('yupe', 'Описание'); ?></th>
                <th><?php echo Yii::t('yupe', 'Версия'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($yiiModules as $module): ?>
                <tr>
                    <td><?php echo $module->id; ?></td>
                    <td><?php echo $module->name; ?></td>
                    <td><?php echo $module->description; ?></td>
                    <td><?php echo $module->version; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php $this->menu = $modulesNavigation; ?>
<h1><?php echo Yii::t('yupe', 'Панель управления "{app}" !',array('{app}' => CHtml::encode(Yii::app()->name)));?></h1>

<p><?php echo Yii::t('yupe', 'Добро пожаловать в панель управления Вашим сайтом!');?></p>

<?php foreach ($modules as $module): ?>
<?php if (is_array($module->checkSelf())): ?>
    <?php $error = $module->checkSelf(); ?>
    <div class="flash-<?php echo $error['type'];?>">
        <b><?php echo Yii::t('yupe','Модуль "{module} ({id})"',array(
            '{module}' => $module->getName(),
            '{id}'     => $module->id
            ));?>:<br/> <?php echo $error['message'];?></b>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<p>Вы используете Yii версии
    <b><?php echo Yii::getVersion();?></b>, <?php echo CHtml::encode(Yii::app()->name);?>
    версии <b><?php echo Yii::app()->yupe->getVersion();?></b>,
    php <?php echo Yii::t('yupe', 'версии');?>
    <b><?php echo phpversion();?></b></p>

<p><?php echo Yii::t('yupe', 'Установлено модулей:');?>
    <b><?php echo count($modules) + count($yiiModules);?></b></p>

<?php if (count($modules)): ?>
<p><?php echo Yii::t('yupe', 'Модули разработанные специально для {app} ',array('{app}' => CHtml::encode(Yii::app()->name)));?>
    (<?php echo count($modules); ?>):</p>
<table class="items">
    <thead>
    <tr>
        <th><?php echo Yii::t('yupe', 'Название');?></th>
        <th><?php echo Yii::t('yupe', 'Категория');?></th>
        <th><?php echo Yii::t('yupe', 'Автор');?></th>
        <th><?php echo Yii::t('yupe', 'Версия');?></th>
        <th><?php echo Yii::t('yupe', 'Описание');?></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($modules as $module): ?>
        <?php $style = is_array($module->checkSelf())
            ? "style='background-color:#FBC2C4;'" : ''; ?>
    <tr <?php echo $style;?>>
        <td><?php echo CHtml::link($module->getName(), array($module->getAdminPageLink())); ?></td>
        <td><?php echo $module->getCategory();?></td>
        <td><?php echo $module->getAuthor(); ?>
            (<?php echo $module->getAuthorEmail(); ?>)
        </td>
        <td><?php echo $module->getVersion(); ?></td>
        <td>
            <?php echo $module->getDescription(); ?>
            <?php echo CHtml::link($module->getUrl(), $module->getUrl()); ?>
        </td>
        <td>
            <?php if ($module->getEditableParams()): ?>
            <?php echo CHtml::link(Yii::t('yupe', 'Настройки'), array('/yupe/backend/modulesettings/', 'module' => $module->getId())); ?>
            <?php endif;?>
        </td>
        <td>
        </td>
    </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php endif; ?>

<?php if (count($yiiModules)): ?>
<p><?php echo Yii::t('yupe', 'Yii модули');?> (<?php echo count($yiiModules);?>
    ):</p>
<table class="items">
    <thead>
    <tr>
        <th><?php echo Yii::t('yupe', 'id');?></th>
        <th><?php echo Yii::t('yupe', 'Название');?></th>
        <th><?php echo Yii::t('yupe', 'Описание');?></th>
        <th><?php echo Yii::t('yupe', 'Версия');?></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($yiiModules as $module): ?>
    <tr>
        <td><?php echo $module->id; ?></td>
        <td><?php echo $module->name; ?></td>
        <td><?php echo $module->description; ?></td>
        <td><?php echo $module->getVersion(); ?></td>
    </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php endif; ?>

<?php $this->menu = $modulesNavigation; ?>
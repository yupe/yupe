<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Настройки модулей'),
);?>

<h1><?php echo Yii::t('yupe','Настройки модулей');?></h1>

<?php echo Yii::t('yupe','Настройте модули "{app}" под Ваши потребности',array('{app}' => Yii::app()->name));?>

<p><?php echo Yii::t('yupe', 'Установлено модулей:');?>
    <b><?php echo count($modules);?></b></p>

<?php if (count($modules)): ?>
<p><?php echo Yii::t('yupe', 'Модули разработанные специально для "{app}" ',array('{app}' => CHtml::encode(Yii::app()->name)));?>
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
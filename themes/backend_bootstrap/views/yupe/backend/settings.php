<?php
$this->breadcrumbs = array(
    Yii::t('yupe', 'Настройки модулей'),
);?>

<h1><?php echo Yii::t('yupe','Настройки модулей');?></h1>

<?php echo Yii::t('yupe','Настройте модули "{app}" под Ваши потребности',array('{app}' => Yii::app()->name));?>

<p><?php echo Yii::t('yupe', 'Установлено');?>
    <b><?php echo $mn=count($modules);?></b>
    <?php echo Yii::t('yupe','модуль|модуля|модулей',$mn); ?>.
</p>

<?php if (count($modules)): ?>
<div class="page-header">
<h6><?php echo Yii::t('yupe', 'Модули разработанные специально для "{app}" ',array('{app}' => CHtml::encode(Yii::app()->name)));?></h6>
</div>
<table class="table table-striped table-vmiddle">
    <thead>
    <tr>
        <th></th>
        <th style="width: 32px;"><?php echo Yii::t('yupe', 'Вер.');?></th>
        <th style="width: 150px;"><?php echo Yii::t('yupe', 'Название');?></th>
        <th><?php echo Yii::t('yupe', 'Описание');?></th>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
        <?php foreach ($modules as $module): ?>
        <?php $style = is_array($module->checkSelf())
            ? "style='background-color:#FBC2C4;'" : ''; ?>
    <tr>
        <td><?php echo ($module->icon?("<i class='icon-".$module->icon."'> </i> "):""); ?></td>
        <td><small class='label <?php
            $v = $module->getVersion();
            if (($n=strpos($v,"(dev)"))!==FALSE)
                echo "label-warning' title='".Yii::t('yupe','Модуль в разработке')."'>".substr($v,0,$n);
            else
                echo "'>".$v;
            ?></small></td>
        <td>
        <small style="font-size: 80%;"><?php echo $module->getCategory();?></small><br />
        <?php echo CHtml::link($module->getName(), array($module->getAdminPageLink())); ?></td>
        <td>
            <?php echo $module->getDescription(); ?>
            <br />
            <small style="font-size: 80%;"> <?php echo "<b>".Yii::t('yupe',"Автор:")."</b> ".$module->getAuthor(); ; ?>
            (<a href="mailto:<?php echo $module->getAuthorEmail()?>"><?php echo $module->getAuthorEmail(); ; ?></a>) &nbsp;
            <?php echo "<b>".Yii::t('yupe',"Сайт модуля:")."</b> ".CHtml::link($module->getUrl(), $module->getUrl()); ; ?></small><br />
        </td>
        <td>
            <?php if ($module->getEditableParams()): ?>
            <?php echo CHtml::link('<i class="icon-wrench" title="'.Yii::t('yupe', 'Настройки').'"> </i>', array('/yupe/backend/modulesettings/', 'module' => $module->getId())); ?>
            <?php endif;?>
        </td>
        <td>
        </td>
    </tr>
        <?php endforeach;?>
    </tbody>
</table>
<?php endif; ?>
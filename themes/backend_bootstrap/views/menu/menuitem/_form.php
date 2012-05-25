<?php $form = $this->beginWidget('bootstrap.widgets.BootActiveForm', array(
    'id' => 'menu-item-form',
    'enableAjaxValidation' => false,
    'htmlOptions'=> array( 'class' => 'well' ),
));

Yii::app()->clientScript->registerScript('fieldset', "
        $('document').ready(function ()
        { $('.popover-help').popover({ 'delay': 500, });
        });
    ");
?>



    <fieldset class="inline">
        <div class="alert alert-info"><?php echo Yii::t('menu', 'Поля, отмеченные * обязательны для заполнения')?></div>

    <?php echo $form->errorSummary($model); ?>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('menu_id')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('menu_id',"Меню к которому добавляете пункт") ?>" data-original-title="<?php echo $model-> getAttributeLabel('menu_id'); ?>" >
                <?php echo $form->labelEx($model, 'menu_id'); ?>
                <?php echo $form->dropDownList($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('menu', 'выберите меню'))); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'menu_id'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('title')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('menu',"Заголовок пункта меню<br /><br />Например:<br /><pre>'О проекте'</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('title'); ?>" >
                <?php echo $form->labelEx($model, 'title'); ?>
                <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'title'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('href')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('href',"Адрес ссылки<br /><br />Например:<br /><pre>'/about/'</pre>") ?>" data-original-title="<?php echo $model-> getAttributeLabel('href'); ?>" >
                <?php echo $form->labelEx($model, 'href'); ?>
                <?php echo $form->textField($model, 'href', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'href'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('parent_id')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('parent_id',"Родительский пункт") ?>" data-original-title="<?php echo $model-> getAttributeLabel('parent_id'); ?>" >
                <?php echo $form->labelEx($model, 'parent_id'); ?>
                <?php echo $form->dropDownList($model, 'parent_id', $model->parentList); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'parent_id'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('condition_name')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('parent_id',"Условие отображения пункта меню") ?>" data-original-title="<?php echo $model-> getAttributeLabel('condition_name'); ?>" >
                <?php echo $form->labelEx($model, 'condition_name'); ?>
                <?php echo $form->dropDownList($model, 'condition_name', $model->conditionList); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'condition_name'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('condition_denial')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('parent_id',"Отрицание условие ?") ?>" data-original-title="<?php echo $model-> getAttributeLabel('condition_denial'); ?>" >
                <?php echo $form->labelEx($model, 'condition_denial'); ?>
                <?php echo $form->dropDownList($model, 'condition_denial', $model->conditionDenialList); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'condition_denial'); ?>
            </div>
        </div>


        <div class="row-fluid control-group <?php echo $model-> hasErrors('sort')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('sort',"Порядок следования пункта меню") ?>" data-original-title="<?php echo $model-> getAttributeLabel('sort'); ?>" >
                <?php echo $form->labelEx($model, 'sort'); ?>
                <?php echo $form->textField($model, 'sort', array('size' => 60, 'maxlength' => 150)); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'sort'); ?>
            </div>
        </div>

        <div class="row-fluid control-group <?php echo $model-> hasErrors('status')?'error':'' ?>">
            <div class="span7 popover-help" data-content="<?=Yii::t('status',"Статус пункта меню") ?>" data-original-title="<?php echo $model-> getAttributeLabel('status'); ?>" >
                <?php echo $form->labelEx($model, 'status'); ?>
                <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
            </div>
            <div class="span5">
                <?php echo $form->error($model, 'status'); ?>
            </div>
        </div>


        <?php $this->widget('bootstrap.widgets.BootButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' =>      $model->isNewRecord
            ? Yii::t('menu', 'Добавить пункт меню')
            : Yii::t('menu', 'Сохранить пункт меню'))); ?>

    </fieldset>
    <?php $this->endWidget(); ?>

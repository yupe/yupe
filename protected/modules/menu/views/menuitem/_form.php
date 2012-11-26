<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'menu-item-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ trigger : 'hover', 'delay' : 500 });
    });
");
?>

    <div class="alert alert-info">
        <?php echo Yii::t('menu', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('menu', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class='control-group <?php echo $model->hasErrors("title") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'title', array('class' => 'span7', 'maxlength' => 300)); ?>
    </div>

     <div class='control-group <?php echo $model->hasErrors("href") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'href', array('class' => 'span7', 'maxlength' => 300)); ?>
     </div>
    
     <div class='control-group <?php echo $model->hasErrors("sort") ? "error" : ""; ?>'>
        <?php echo $form->textFieldRow($model, 'sort', array('class' => 'span7', 'maxlength' => 300)); ?>
     </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('menu_id') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('menu_id', "Меню к которому добавляете пункт"); ?>" data-original-title="<?php echo $model->getAttributeLabel('menu_id'); ?>">
            <?php echo $form->labelEx($model, 'menu_id'); ?>
            <?php echo $form->dropDownList($model, 'menu_id', CHtml::listData(Menu::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('menu', '--выберите меню--'))); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'menu_id'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('parent_id') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('parent_id', "Родительский пункт"); ?>" data-original-title="<?php echo $model->getAttributeLabel('parent_id'); ?>">
            <?php echo $form->labelEx($model, 'parent_id'); ?>
            <?php echo $form->dropDownList($model, 'parent_id', $model->parentList); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'parent_id'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('condition_name') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('parent_id', "Условие отображения пункта меню") ?>" data-original-title="<?php echo $model->getAttributeLabel('condition_name'); ?>">
            <?php echo $form->labelEx($model, 'condition_name'); ?>
            <?php echo $form->dropDownList($model, 'condition_name', $model->conditionList); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'condition_name'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('condition_denial') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('parent_id', "Отрицание условие ?"); ?>" data-original-title="<?php echo $model->getAttributeLabel('condition_denial'); ?>">
            <?php echo $form->labelEx($model, 'condition_denial'); ?>
            <?php echo $form->dropDownList($model, 'condition_denial', $model->conditionDenialList); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'condition_denial'); ?>
        </div>
    </div>  

    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('status', "Статус пункта меню"); ?>" data-original-title="<?php echo $model->getAttributeLabel('status'); ?>">
            <?php echo $form->labelEx($model, 'status'); ?>
            <?php echo $form->dropDownList($model, 'status', $model->getStatusList()); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'status'); ?>
        </div>
    </div>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('menu', 'Добавить пункт меню и продолжить') : Yii::t('menu', 'Сохранить пункт меню и продолжить'),
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('menu', 'Добавить пункт меню и закрыть') : Yii::t('menu', 'Сохранить пункт меню и закрыть'),
      )); ?>

<?php $this->endWidget(); ?>
<script type='text/javascript'>
    $(document).ready(function(){
        $('#good-form').liTranslit({
            elName: '#Good_name',
            elAlias: '#Good_alias'
        });
    })
</script>


<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'good-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
    'inlineErrors'           => true,
)); ?>

    <div class="alert alert-info">
        <?php echo Yii::t('CatalogModule.catalog', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('CatalogModule.catalog', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('is_special')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
        <div class="span3">
            <br /><br />
            <?php echo $form->checkBoxRow($model, 'is_special', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('is_special'), 'data-content' => $model->getAttributeDescription('is_special'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('empty' => Yii::t('CatalogModule.catalog', '--выберите--'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span7 popover-help', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('alias') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span7 popover-help', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('alias'), 'data-content' => $model->getAttributeDescription('alias'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('price') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'price', array('class' => 'span7 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('price'), 'data-content' => $model->getAttributeDescription('price'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('article') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'article', array('class' => 'span7 popover-help', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('article'), 'data-content' => $model->getAttributeDescription('article'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('image') ? 'error' : ''; ?>">
        <?php if(!$model->isNewRecord && $model->image):?>
            <?php echo CHtml::image($model->imageUrl, $model->name, array('width' => 300, 'height' => 300)); ?>
        <?php endif; ?>
        <?php echo $form->fileFieldRow($model, 'image', array('class' => 'span4 popover-help', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('image'), 'data-content' => $model->getAttributeDescription('image'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('description'); ?>' data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'description',
                'options'     => $this->module->editorOptions,
            )); ?>
         </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('short_description') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('short_description'); ?>' data-content='<?php echo $model->getAttributeDescription('short_description'); ?>'>
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget($this->module->editor, array(
            'model'       => $model,
            'attribute'   => 'short_description',
            'options'     => $this->module->editorOptions,
        )); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('data') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('data'); ?>' data-content='<?php echo $model->getAttributeDescription('data'); ?>'>
            <?php echo $form->labelEx($model, 'data'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'data',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
    </div>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CatalogModule.catalog', 'Добавить товар и продолжить') : Yii::t('CatalogModule.catalog', 'Сохранить товар и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => $model->isNewRecord ? Yii::t('CatalogModule.catalog', 'Добавить товар и закрыть') : Yii::t('CatalogModule.catalog', 'Сохранить товар и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>

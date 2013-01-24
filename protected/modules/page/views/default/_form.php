<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'page-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('PageModule.page', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('PageModule.page', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('category_id') || $model->hasErrors('parent_id')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('empty' => Yii::t('PageModule.page', '--выберите--'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->dropDownListRow($model, 'parent_id', $pages, array('empty' => Yii::t('PageModule.page', '--выберите--'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('parent_id'), 'data-content' => $model->getAttributeDescription('parent_id'))); ?>
        </div>
    </div>
    <div class="wide row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('order')) ? 'error' : ''; ?>">
        <div class="span4">
            <?php echo $form->dropDownListRow($model, 'status', $model->statusList, array('class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
        </div>
        <div class="span3">
            <?php echo $form->textFieldRow($model, 'order', array('size' => 10, 'maxlength' => 10, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('order'), 'data-content' => $model->getAttributeDescription('order'))); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('title_short') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'title_short', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('title_short'), 'data-content' => $model->getAttributeDescription('title_short'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('title') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'slug', array('size' => 60, 'maxlength' => 150, 'placeholder' => Yii::t('PageModule.page', 'Оставьте пустым для автоматической генерации'), 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('is_protected') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($model, 'is_protected', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('is_protected'), 'data-content' => $model->getAttributeDescription('is_protected'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('body') ? 'error' : ''; ?>">
        <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('body'); ?>' data-content='<?php echo $model->getAttributeDescription('body'); ?>'>
            <?php echo $form->labelEx($model, 'body'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'body',
                'options'     => $this->module->editorOptions,
            )); ?>
        </div>
    </div>

    <?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse');?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                <?php echo Yii::t('PageModule.page','Данные для поисковой оптимизации');?>
            </a>
        </div>
        <div id="collapseOne" class="accordion-body collapse">
            <div class="accordion-inner">
                <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
                    <?php echo $form->textFieldRow($model, 'keywords', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('keywords'), 'data-content' => $model->getAttributeDescription('keywords'))); ?>
                </div>
                <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
                    <?php echo $form->textAreaRow($model, 'description', array('rows' => 3, 'cols' => 98, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
                </div>
            </div>
        </div>
    </div>
    <?php $this->endWidget();?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить страницу и продолжить') : Yii::t('blog', 'Сохранить страницу и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions'=> array('name' => 'submit-type', 'value' => 'index'),
        'label'      => $model->isNewRecord ? Yii::t('blog', 'Добавить страницу и закрыть') : Yii::t('blog', 'Сохранить страницу и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>

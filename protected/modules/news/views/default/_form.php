<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'id'                     => 'news-form',
    'enableAjaxValidation'   => false,
    'enableClientValidation' => true,
    'type'                   => 'vertical',
    'htmlOptions'            => array('class' => 'well', 'enctype'=>'multipart/form-data'),
    'inlineErrors'           => true,
)); ?>
    <div class="alert alert-info">
        <?php echo Yii::t('NewsModule.news', 'Поля, отмеченные'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('NewsModule.news', 'обязательны.'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('date') ? 'error' : ''; ?>">
        <div class="span7 popover-help" data-content="<?php echo Yii::t('NewsModule.news', "Дата публикации новости, также используется для упорядочивания списка новостей."); ?>" data-original-title="<?php echo $model->getAttributeLabel('date'); ?>">
            <?php echo $form->labelEx($model, 'date'); ?>
            <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'     => $model,
            'attribute' => 'date',
            'language'  => Yii::app()->language,
            'options'   => array('dateFormat' => 'dd.mm.yy'),
            'htmlOptions' => array('class' => 'span7 popover-help')
        )); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'date'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'category_id' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData($this->module->getCategoryList(), 'id', 'name'), array('class' => 'span7 popover-help','empty' => Yii::t('NewsModule.news', '--выберите--'))); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('title') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'title', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('alias') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'alias', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('alias'), 'data-content' => $model->getAttributeDescription('alias'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">
        <?php echo $form->textFieldRow($model, 'link', array('size' => 60, 'maxlength' => 150, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('link'), 'data-content' => $model->getAttributeDescription('link'))); ?>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('image') ? 'error' : ''; ?>">
        <div class="span7  popover-help"  data-original-title="<?php echo $model->getAttributeLabel('image'); ?>">
            <?php if (!$model->isNewRecord && $model->image): ?>
                <?php echo CHtml::image($model->imageUrl, $model->name, array('width'  => 300, 'height' => 300)); ?>
            <?php endif; ?>
            <?php echo $form->labelEx($model, 'image'); ?>
            <?php echo $form->fileField($model, 'image'); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'image'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('full_text') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'full_text'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'full_text',
                'options'     => $this->module->editorOptions,
            )); ?>
            <span class="help-block"><?php echo Yii::t('NewsModule.news', "Полный текст новости отображается при переходе по ссылке &laquo;Подробнее&raquo; или иногда при клике на заголовке новости."); ?></span>
            <?php echo $form->error($model, 'full_text'); ?>
        </div>
    </div>
    <div class="row-fluid control-group <?php echo $model->hasErrors('short_text') ? 'error' : ''; ?>">
        <div class="span12">
            <?php echo $form->labelEx($model, 'short_text'); ?>
            <?php $this->widget($this->module->editor, array(
                'model'       => $model,
                'attribute'   => 'short_text',
                'options'     => $this->module->editorOptions,
            )); ?>
            <span class="help-block"><?php echo Yii::t('NewsModule.news', "Опишите основную мысль новости или напишие некий вводный текст (анонс), пары предложений обычно достаточно. Данный текст используется при выводе списка новостей, например, на главной странице."); ?></span>
            <?php echo $form->error($model, 'short_text'); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('is_protected') ? 'error' : ''; ?>">
        <?php echo $form->checkBoxRow($model, 'is_protected', $model->getProtectedStatusList()); ?>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('status') ? 'error' : ''; ?>">
         <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(),array('class' => 'span7 popover-help')); ?>
    </div>

    <?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse');?>
    <div class="accordion-group">
        <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
                <?php echo Yii::t('NewsModule.news','Данные для поисковой оптимизации');?>
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

    <br/>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type'       => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('NewsModule.news', 'Добавить новость и продолжить') : Yii::t('NewsModule.news', 'Сохранить новость и продолжить'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('NewsModule.news', 'Добавить новость и закрыть') : Yii::t('NewsModule.news', 'Сохранить новость и закрыть'),
    )); ?>

<?php $this->endWidget(); ?>

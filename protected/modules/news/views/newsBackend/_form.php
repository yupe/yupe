<script type='text/javascript'>
    $(document).ready(function(){
        $('#news-form').liTranslit({
            elName: '#News_title',
            elAlias: '#News_alias'
        });
    })
</script>

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
        <?php echo Yii::t('NewsModule.news', 'Fields with'); ?>
        <span class="required">*</span>
        <?php echo Yii::t('NewsModule.news', 'are required'); ?>
    </div>

    <?php echo $form->errorSummary($model); ?>

    <?php if(count($languages) > 1):?>
        <?php echo $form->dropDownListRow($model, 'lang', $languages, array('class' => 'popover-help','empty' => Yii::t('NewsModule.news', '--choose--'))); ?>
        <?php if(!$model->isNewRecord):?>
            <?php foreach($languages as $k => $v):?>
                <?php if($k !== $model->lang):?>
                    <?php if(empty($langModels[$k])):?>
                        <a href="<?php echo $this->createUrl('/news/newsBackend/create',array('id' => $model->id,'lang'  => $k));?>"><i class="iconflags iconflags-<?php echo $k;?>" title="<?php echo Yii::t('NewsModule.news','Add translation for {lang} language',array('{lang}' => $v))?>"></i></a>
                    <?php else:?>
                        <a href="<?php echo $this->createUrl('/news/newsBackend/update',array('id' => $langModels[$k]));?>"><i class="iconflags iconflags-<?php echo $k;?>" title="<?php echo Yii::t('NewsModule.news','Edit translation in to {lang} language',array('{lang}' => $v))?>"></i></a>
                    <?php endif;?>
                <?php endif;?>
            <?php endforeach;?>
        <?php endif;?>
    <?php else:?>
        <?php echo $form->hiddenField($model,'lang');?>
    <?php endif;?>

    <div class="row-fluid control-group <?php echo $model->hasErrors('date') ? 'error' : ''; ?>">
        <div class="span4 popover-help" data-original-title='<?php echo $model->getAttributeLabel('date'); ?>' data-content='<?php echo $model->getAttributeDescription('date'); ?>'>
            <?php
            echo $form->datepickerRow(
                $model, 'date', array(
                    'prepend' => '<i class="icon-calendar"></i>',
                    'options' => array(
                        'format'    => 'dd.mm.yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ),
                    'class'   => 'span11'
                )
            ); ?>
        </div>
    </div>

    <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
        <?php echo $form->dropDownListRow($model, 'category_id', Category::model()->getFormattedList((int)Yii::app()->getModule('news')->mainCategory), array('class' => 'span7 popover-help','empty' => Yii::t('NewsModule.news', '--choose--'), 'encode' => false)); ?>
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
                <?php echo CHtml::image($model->imageUrl, $model->title, array('width'  => 300, 'height' => 300)); ?>
            <?php endif; ?>
            <?php echo $form->labelEx($model, 'image'); ?>
            <?php echo $form->fileField($model, 'image'); ?>
        </div>
        <div class="span5">
            <?php echo $form->error($model, 'image'); ?>
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
            <span class="help-block"><?php echo Yii::t('NewsModule.news', 'News anounce text. Usually this is the main idea of the article.'); ?></span>
            <?php echo $form->error($model, 'short_text'); ?>
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
            <span class="help-block"><?php echo Yii::t('NewsModule.news', 'Full text news which will be shown on news article page'); ?></span>
            <?php echo $form->error($model, 'full_text'); ?>
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
                <?php echo Yii::t('NewsModule.news','Data for SEO');?>
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
        'label'      => $model->isNewRecord ? Yii::t('NewsModule.news', 'Create article and continue') : Yii::t('NewsModule.news', 'Save news article and continue'),
    )); ?>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('NewsModule.news', 'Create article and close') : Yii::t('NewsModule.news', 'Save news article and close'),
    )); ?>

<?php $this->endWidget(); ?>

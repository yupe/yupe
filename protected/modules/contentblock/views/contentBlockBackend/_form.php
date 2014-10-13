<script type='text/javascript'>
    $(document).ready(function () {
        $('#content-block-form').liTranslit({
            elName: '#ContentBlock_name',
            elAlias: '#ContentBlock_code'
        });
    })
</script>

<?php
/* @var $model ContentBlock */
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'content-block-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('ContentBlockModule.contentblock', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('ContentBlockModule.contentblock', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            array('widgetOptions' => array('data' => $model->getTypes()))
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'code'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            array(
                'widgetOptions' => array(
                    'data'        => Category::model()->getFormattedList(),
                    'htmlOptions' => array(
                        'empty'               => Yii::t('ContentBlockModule.contentblock','--choose--'),
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('category_id'),
                        'data-content'        => $model->getAttributeDescription('category_id'),
                        'encode'              => false
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group">
        <?php if (!$model->isNewRecord && $model->type == ContentBlock::HTML_TEXT): ?>
            <?php echo $form->labelEx($model, 'content'); ?>
            <?php $this->widget(
                $this->yupe->getVisualEditor(),
                array(
                    'model'     => $model,
                    'attribute' => 'content',
                )
            ); ?>
            <?php echo $form->error($model, 'content'); ?>
        <?php else: ?>
            <?php echo $form->textAreaGroup(
                $model,
                'content',
                array('widgetOptions' => array('htmlOptions' => array('rows' => 6)))
            ); ?>
        <?php endif; ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->yupe->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'description',
            )
        ); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t(
                'ContentBlockModule.contentblock',
                'Add block and continue'
            ) : Yii::t('ContentBlockModule.contentblock', 'Save block and continue'),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t(
                'ContentBlockModule.contentblock',
                'Add block and close'
            ) : Yii::t('ContentBlockModule.contentblock', 'Save block and close'),
    )
); ?>

<?php $this->endWidget(); ?>

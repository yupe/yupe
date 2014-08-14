<script type='text/javascript'>
    $(document).ready(function () {
        $('#category-form').liTranslit({
            elName: '#StoreCategory_name',
            elAlias: '#StoreCategory_alias'
        });
    })
</script>


<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'category-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('StoreModule.category', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('StoreModule.category', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'parent_id',
            array(
                'widgetOptions' => array(
                    'data' => StoreCategory::model()->getFormattedList(),
                    'htmlOptions' => array(
                        'empty' => Yii::t('StoreModule.category', '--no--'),
                        'encode' => false,
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'alias'); ?>
    </div>
</div>
<div class='row'>
    <div class="col-sm-7">
        <?php
        echo CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->name,
            array(
                'class' => 'preview-image img-thumbnail',
                'style' => !$model->isNewRecord && $model->image ? '' : 'display:none'
            )
        ); ?>
        <?php echo $form->fileFieldGroup(
            $model,
            'image',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'onchange' => 'readURL(this);',
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->editor,
            array(
                'model' => $model,
                'attribute' => 'description',
                'options' => $this->module->editorOptions,
            )
        ); ?>
        <p class="help-block"></p>
        <?php echo $form->error($model, 'description'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12 <?php echo $model->hasErrors('short_description') ? 'has-error' : ''; ?>">
        <?php echo $form->labelEx($model, 'short_description'); ?>
        <?php $this->widget(
            $this->module->editor,
            array(
                'model' => $model,
                'attribute' => 'short_description',
                'options' => $this->module->editorOptions,
            )
        ); ?>
        <p class="help-block"></p>
        <?php echo $form->error($model, 'short_description'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array(
                'widgetOptions' => array(
                    'data' => $model->getStatusList(),
                ),
            )
        ); ?>
    </div>
</div>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="panel-group" id="extended-options">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <a data-toggle="collapse" data-parent="#extended-options" href="#collapseOne">
                    <?php echo Yii::t('StoreModule.category', 'Data for SEO'); ?>
                </a>
            </div>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textFieldGroup($model, 'meta_title'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textFieldGroup($model, 'meta_keywords'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?php echo $form->textAreaGroup($model, 'meta_description'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('StoreModule.category', 'Create category and continue') : Yii::t('StoreModule.category', 'Save category and continue'),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => $model->isNewRecord ? Yii::t('StoreModule.category', 'Create category and close') : Yii::t('StoreModule.category', 'Save category and close'),
    )
); ?>

<?php $this->endWidget(); ?>

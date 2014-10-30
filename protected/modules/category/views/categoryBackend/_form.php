<script type='text/javascript'>
    $(document).ready(function () {
        $('#category-form').liTranslit({
            elName: '#Category_name',
            elAlias: '#Category_alias'
        });
    })
</script>


<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'category-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('CategoryModule.category', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('CategoryModule.category', 'are required'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">

    <div class='col-sm-3'>
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


    <div class="col-sm-4">

        <?php if (count($languages) > 1): { ?>
            <?php echo $form->dropDownListGroup(
                $model,
                'lang',
                array(
                    'widgetOptions' => array(
                        'data'        => $languages,
                        'htmlOptions' => array(
                            'empty' => Yii::t('CategoryModule.category', '--choose--'),
                        ),
                    ),
                )
            ); ?>
            <?php if (!$model->isNewRecord): { ?>
                <?php foreach ($languages as $k => $v): { ?>
                    <?php if ($k !== $model->lang): { ?>
                        <?php if (empty($langModels[$k])): { ?>
                            <a href="<?php echo $this->createUrl(
                                '/category/categoryBackend/create',
                                array('id' => $model->id, 'lang' => $k)
                            ); ?>"><i class="iconflags iconflags-<?php echo $k; ?>" title="<?php echo Yii::t(
                                    'CategoryModule.category',
                                    'Add translate in to {lang}',
                                    array('{lang}' => $v)
                                ) ?>"></i></a>
                        <?php } else: { ?>
                            <a href="<?php echo $this->createUrl(
                                '/category/categoryBackend/update',
                                array('id' => $langModels[$k])
                            ); ?>"><i class="iconflags iconflags-<?php echo $k; ?>" title="<?php echo Yii::t(
                                    'CategoryModule.category',
                                    'Change translation in to {lang}',
                                    array('{lang}' => $v)
                                ) ?>"></i></a>
                        <?php } endif; ?>
                    <?php } endif; ?>
                <?php } endforeach; ?>
            <?php } endif; ?>
        <?php } else: { ?>
            <?php echo $form->hiddenField($model, 'lang'); ?>
        <?php } endif; ?>

    </div>

</div>

<div class='row'>
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'parent_id',
            array(
                'widgetOptions' => array(
                    'data'        => Category::model()->getFormattedList(),
                    'htmlOptions' => array(
                        'empty'  => Yii::t('CategoryModule.category', '--no--'),
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
                'class' => 'preview-image',
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
                        'style'    => 'background-color: inherit;'
                    )
                )
            )
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                array(
                    'model'     => $model,
                    'attribute' => 'description',
                )
            ); ?>
            <?php echo $form->error($model, 'description', array('class' => 'help-block error')); ?>
        </div>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                array(
                    'model'     => $model,
                    'attribute' => 'short_description',
                )
            ); ?>
            <br/>
            <?php echo $form->error($model, 'short_description', array('class' => 'help-block error')); ?>
        </div>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t(
                'CategoryModule.category',
                'Create category and continue'
            ) : Yii::t(
                'CategoryModule.category',
                'Save category and continue'
            ),
    )
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('CategoryModule.category', 'Create category and close') : Yii::t(
                'CategoryModule.category',
                'Save category and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>

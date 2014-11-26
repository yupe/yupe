<script type='text/javascript'>
    $(document).ready(function () {
        $('#good-form').liTranslit({
            elName: '#Good_name',
            elAlias: '#Good_alias'
        });
    })
</script>


<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'good-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>

<div class="alert alert-info">
    <?php echo Yii::t('CatalogModule.catalog', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('CatalogModule.catalog', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('status'),
                        'data-content'        => $model->getAttributeDescription('status')
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
        <br/>
        <?php echo $form->checkBoxGroup(
            $model,
            'is_special',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('is_special'),
                        'data-content'        => $model->getAttributeDescription('is_special')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            [
                'widgetOptions' => [
                    'data'        => Category::model()->getFormattedList(),
                    'htmlOptions' => [
                        'empty'               => Yii::t('CatalogModule.catalog', '--choose--'),
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('category_id'),
                        'data-content'        => $model->getAttributeDescription('category_id'),
                        'encode'              => false,
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'name',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('name'),
                        'data-content'        => $model->getAttributeDescription('name')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'alias',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('alias'),
                        'data-content'        => $model->getAttributeDescription('alias')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'price',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('price'),
                        'data-content'        => $model->getAttributeDescription('price')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'article',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('article'),
                        'data-content'        => $model->getAttributeDescription('article')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php
        echo CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->name,
            [
                'class' => 'preview-image',
                'style' => !$model->isNewRecord && $model->image ? '' : 'display:none'
            ]
        ); ?>
        <?php echo $form->fileFieldGroup(
            $model,
            'image',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'onchange' => 'readURL(this);',
                        'style'    => 'background-color: inherit;'
                    ]
                ]
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="popover-help form-group"
             data-original-title='<?php echo $model->getAttributeLabel('description'); ?>'
             data-content='<?php echo $model->getAttributeDescription('description'); ?>'>
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model'     => $model,
                    'attribute' => 'description',
                ]
            ); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="popover-help form-group"
             data-original-title='<?php echo $model->getAttributeLabel('short_description'); ?>'
             data-content='<?php echo $model->getAttributeDescription(
                 'short_description'
             ); ?>'>
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model'     => $model,
                    'attribute' => 'short_description',
                ]
            ); ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="popover-help form-group" data-original-title='<?php echo $model->getAttributeLabel('data'); ?>'
             data-content='<?php echo $model->getAttributeDescription('data'); ?>'>
            <?php echo $form->labelEx($model, 'data'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model'     => $model,
                    'attribute' => 'data',
                ]
            ); ?>
        </div>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('CatalogModule.catalog', 'Add product and continue') : Yii::t(
                'CatalogModule.catalog',
                'Save product and continue'
            ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('CatalogModule.catalog', 'Add product and close') : Yii::t(
                'CatalogModule.catalog',
                'Save product and close'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>

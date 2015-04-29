<?php
/**
 * @var $this CategoryBackendController
 * @var $form \yupe\widgets\ActiveForm
 * @var $model Category
 */

$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'category-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
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
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>


    <div class="col-sm-4">

        <?php if (count($languages) > 1): { ?>
            <?php echo $form->dropDownListGroup(
                $model,
                'lang',
                [
                    'widgetOptions' => [
                        'data'        => $languages,
                        'htmlOptions' => [
                            'empty' => Yii::t('CategoryModule.category', '--choose--'),
                        ],
                    ],
                ]
            ); ?>
            <?php if (!$model->isNewRecord): { ?>
                <?php foreach ($languages as $k => $v): { ?>
                    <?php if ($k !== $model->lang): { ?>
                        <?php if (empty($langModels[$k])): { ?>
                            <a href="<?php echo $this->createUrl(
                                '/category/categoryBackend/create',
                                ['id' => $model->id, 'lang' => $k]
                            ); ?>"><i class="iconflags iconflags-<?php echo $k; ?>" title="<?php echo Yii::t(
                                    'CategoryModule.category',
                                    'Add translate in to {lang}',
                                    ['{lang}' => $v]
                                ) ?>"></i></a>
                        <?php } else: { ?>
                            <a href="<?php echo $this->createUrl(
                                '/category/categoryBackend/update',
                                ['id' => $langModels[$k]]
                            ); ?>"><i class="iconflags iconflags-<?php echo $k; ?>" title="<?php echo Yii::t(
                                    'CategoryModule.category',
                                    'Change translation in to {lang}',
                                    ['{lang}' => $v]
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
            [
                'widgetOptions' => [
                    'data'        => Category::model()->getFormattedList(),
                    'htmlOptions' => [
                        'empty'  => Yii::t('CategoryModule.category', '--no--'),
                        'encode' => false,
                    ],
                ],
            ]
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
        <?php echo $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'name']); ?>
    </div>
</div>
<div class='row'>
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

        <?php if (!$model->isNewRecord && $model->image): ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="delete-file"> <?= Yii::t('YupeModule.yupe', 'Delete the file') ?>
                </label>
            </div>
        <?php endif; ?>

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

<div class='row'>
    <div class="col-sm-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model'     => $model,
                    'attribute' => 'description',
                ]
            ); ?>
            <?php echo $form->error($model, 'description', ['class' => 'help-block error']); ?>
        </div>
    </div>
</div>

<div class='row'>
    <div class="col-sm-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'short_description'); ?>
            <?php $this->widget(
                $this->module->getVisualEditor(),
                [
                    'model'     => $model,
                    'attribute' => 'short_description',
                ]
            ); ?>
            <br/>
            <?php echo $form->error($model, 'short_description', ['class' => 'help-block error']); ?>
        </div>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t(
            'CategoryModule.category',
            'Create category and continue'
        ) : Yii::t(
            'CategoryModule.category',
            'Save category and continue'
        ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('CategoryModule.category', 'Create category and close') : Yii::t(
            'CategoryModule.category',
            'Save category and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>

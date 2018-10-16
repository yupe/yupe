<?php
/**
 * @var $this NewsBackendController
 * @var $model News
 * @var $form \yupe\widgets\ActiveForm
 */
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id' => 'news-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>
<div class="alert alert-info">
    <?= Yii::t('NewsModule.news', 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t('NewsModule.news', 'are required'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class="row">

    <div class="col-sm-3">
        <?= $form->datePickerGroup(
            $model,
            'date',
            [
                'widgetOptions' => [
                    'options' => [
                        'format' => 'dd-mm-yyyy',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ],
                ],
                'prepend' => '<i class="fa fa-calendar"></i>',
            ]
        );
        ?>
    </div>

    <div class="col-sm-2">
        <?= $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>

    <div class="col-sm-2">
        <?php if (count($languages) > 1): { ?>
            <?= $form->dropDownListGroup(
                $model,
                'lang',
                [
                    'widgetOptions' => [
                        'data' => $languages,
                        'htmlOptions' => [
                            'empty' => Yii::t('NewsModule.news', '-no matter-'),
                        ],
                    ],
                ]
            ); ?>
            <?php if (!$model->isNewRecord): { ?>
                <?php foreach ($languages as $k => $v): { ?>
                    <?php if ($k !== $model->lang): { ?>
                        <?php if (empty($langModels[$k])): { ?>
                            <a href="<?= $this->createUrl(
                                '/news/newsBackend/create',
                                ['id' => $model->id, 'lang' => $k]
                            ); ?>"><i class="iconflags iconflags-<?= $k; ?>" title="<?= Yii::t(
                                    'NewsModule.news',
                                    'Add translation for {lang} language',
                                    ['{lang}' => $v]
                                ) ?>"></i></a>
                        <?php } else: { ?>
                            <a href="<?= $this->createUrl(
                                '/news/newsBackend/update',
                                ['id' => $langModels[$k]]
                            ); ?>"><i class="iconflags iconflags-<?= $k; ?>" title="<?= Yii::t(
                                    'NewsModule.news',
                                    'Edit translation in to {lang} language',
                                    ['{lang}' => $v]
                                ) ?>"></i></a>
                        <?php } endif; ?>
                    <?php } endif; ?>
                <?php } endforeach; ?>
            <?php } endif; ?>
        <?php } else: { ?>
            <?= $form->hiddenField($model, 'lang'); ?>
        <?php } endif; ?>
    </div>

</div>

<div class="row">
    <div class="col-sm-7">
        <?= $form->dropDownListGroup(
            $model,
            'category_id',
            [
                'widgetOptions' => [
                    'data' => Yii::app()->getComponent('categoriesRepository')->getFormattedList(
                        (int)Yii::app()->getModule('news')->mainCategory
                    ),
                    'htmlOptions' => [
                        'empty' => Yii::t('NewsModule.news', '--choose--'),
                        'encode' => false,
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'title'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?= $form->slugFieldGroup($model, 'slug', ['sourceAttribute' => 'title']); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php
        echo CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->title,
            [
                'class' => 'preview-image img-responsive',
                'style' => !$model->isNewRecord && $model->image ? '' : 'display:none',
            ]
        ); ?>

        <?php if (!$model->isNewRecord && $model->image): ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="delete-file"> <?= Yii::t('YupeModule.yupe', 'Delete the file') ?>
                </label>
            </div>
        <?php endif; ?>

        <?= $form->fileFieldGroup(
            $model,
            'image',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'onchange' => 'readURL(this);',
                        'style' => 'background-color: inherit;',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12 <?= $model->hasErrors('full_text') ? 'has-error' : ''; ?>">
        <?= $form->labelEx($model, 'full_text'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model' => $model,
                'attribute' => 'full_text',
            ]
        ); ?>
        <span class="help-block">
            <?= Yii::t(
                'NewsModule.news',
                'Full text news which will be shown on news article page'
            ); ?>
        </span>
        <?= $form->error($model, 'full_text'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?= $form->labelEx($model, 'short_text'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model' => $model,
                'attribute' => 'short_text',
            ]
        ); ?>
        <span class="help-block">
            <?= Yii::t(
                'NewsModule.news',
                'News anounce text. Usually this is the main idea of the article.'
            ); ?>
        </span>
        <?= $form->error($model, 'short_text'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'link'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?= $form->checkBoxGroup($model, 'is_protected', $model->getProtectedStatusList()); ?>
    </div>
</div>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="panel-group" id="extended-options">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <a data-toggle="collapse" data-parent="#extended-options" href="#collapseOne">
                    <?= Yii::t('NewsModule.news', 'Data for SEO'); ?>
                </a>
            </div>
        </div>
        <div id="collapseOne" class="panel-collapse collapse">
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-7">
                        <?= $form->textFieldGroup($model, 'keywords'); ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-7">
                        <?= $form->textAreaGroup($model, 'description'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<br/>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('NewsModule.news', 'Create article and continue') : Yii::t(
            'NewsModule.news',
            'Save news article and continue'
        ),
    ]
); ?>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->isNewRecord ? Yii::t('NewsModule.news', 'Create article and close') : Yii::t(
            'NewsModule.news',
            'Save news article and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>

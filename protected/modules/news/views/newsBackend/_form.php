<?php
/**
 * @var $this NewsBackendController
 * @var $model News
 * @var $form \yupe\widgets\ActiveForm
 */ ?>
<ul class="nav nav-tabs">
    <li class="active"><a href="#common" data-toggle="tab"><?= Yii::t("NewsModule.news", "General"); ?></a></li>
    <li><a href="#seo" data-toggle="tab"><?= Yii::t("NewsModule.news", "SEO"); ?></a></li>
</ul>

<?php
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


<?= $form->errorSummary($model); ?>

<div class="tab-content">
    <div class="tab-pane active" id="common">

        <div class="alert alert-info">
            <?= Yii::t('NewsModule.news', 'Fields with'); ?>
            <span class="required">*</span>
            <?= Yii::t('NewsModule.news', 'are required'); ?>
        </div>

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
                            <input type="checkbox"
                                   name="delete-file"> <?= Yii::t('YupeModule.yupe', 'Delete the file') ?>
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
    </div>

    <div class="tab-pane" id="seo">
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'meta_title'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup($model, 'meta_keywords'); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textAreaGroup($model, 'meta_description'); ?>
            </div>
        </div>
    </div>
</div>

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

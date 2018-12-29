<?php
/**
 * Отображение для postBackend/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     https://yupe.ru
 *
 * @var $form \yupe\widgets\ActiveForm
 * @var $model Post
 * @var $this PostController
 **/
?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#common" data-toggle="tab"><?= Yii::t("BlogModule.blog", "General"); ?></a></li>
    <li><a href="#seo" data-toggle="tab"><?= Yii::t("BlogModule.blog", "Data for SEO"); ?></a></li>
</ul>

<? $form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id' => 'post-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
);

?>
<div class="alert alert-info">
    <?= Yii::t('BlogModule.blog', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?= Yii::t('BlogModule.blog', 'are required.'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class="tab-content">
    <div class="tab-pane active" id="common">

        <div class="row">
            <div class="col-sm-3">
                <?= $form->select2Group(
                    $model,
                    'blog_id',
                    [
                        'widgetOptions' => [
                            'data' => ['' => '---'] + CHtml::listData(Blog::model()->getList(), 'id', 'name'),
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->dropDownListGroup(
                    $model,
                    'status',
                    [
                        'widgetOptions' => [
                            'data' => $model->getStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('status'),
                                'data-content' => $model->getAttributeDescription('status'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-3">
                <?= $form->dateTimePickerGroup(
                    $model,
                    'publish_time',
                    [
                        'widgetOptions' => [
                            'options' => [
                                'format' => 'dd-mm-yyyy hh:ii',
                                'weekStart' => 1,
                                'autoclose' => true,
                            ],
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('publish_time'),
                                'data-content' => $model->getAttributeDescription('publish_time'),
                            ],
                        ],
                        'prepend' => '<i class="fa fa-calendar"></i>',
                    ]
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2">
                <?= $form->dropDownListGroup(
                    $model,
                    'category_id',
                    [
                        'widgetOptions' => [
                            'data' => Yii::app()->getComponent('categoriesRepository')->getFormattedList(
                                (int)Yii::app()->getModule('blog')->mainPostCategory
                            ),
                            'htmlOptions' => [
                                'empty' => Yii::t('BlogModule.blog', '--choose--'),
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('category_id'),
                                'data-content' => $model->getAttributeDescription('category_id'),
                                'data-container' => "body",
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->dropDownListGroup(
                    $model,
                    'access_type',
                    [
                        'widgetOptions' => [
                            'data' => $model->getAccessTypeList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('access_type'),
                                'data-content' => $model->getAttributeDescription('access_type'),
                                'data-container' => "body",
                            ],
                        ],
                    ]
                ); ?>
            </div>
            <div class="col-sm-2">
                <?= $form->dropDownListGroup(
                    $model,
                    'comment_status',
                    [
                        'widgetOptions' => [
                            'data' => $model->getCommentStatusList(),
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('comment_status'),
                                'data-content' => $model->getAttributeDescription('comment_status'),
                                'data-container' => "body",
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup(
                    $model,
                    'title',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('title'),
                                'data-content' => $model->getAttributeDescription('title'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->slugFieldGroup(
                    $model,
                    'slug',
                    [
                        'sourceAttribute' => 'title',
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('slug'),
                                'data-content' => $model->getAttributeDescription('slug'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup(
                    $model,
                    'link',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('link'),
                                'data-content' => $model->getAttributeDescription('link'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <?= $form->labelEx($model, 'tags', ['control-label']); ?>
                    <?php
                    $this->widget(
                        'booster.widgets.TbSelect2',
                        [
                            'asDropDownList' => false,
                            'name' => 'tags',
                            'options' => [
                                'tags' => array_values(CHtml::listData(Tag::model()->findAll(), 'id', 'name')),
                                'placeholder' => Yii::t('BlogModule.blog', 'tags'),
                            ],
                            'value' => implode(", ", $model->getTags()),
                            'htmlOptions' => [
                                'class' => 'form-control popover-help',
                                'data-original-title' => $model->getAttributeLabel('tags'),
                                'data-content' => $model->getAttributeDescription('tags'),
                            ],
                        ]
                    ); ?>
                </div>
            </div>
        </div>
        <div class='row'>
            <div class="col-sm-7">
                <?php
                echo CHtml::image(
                    !$model->getIsNewRecord() && $model->image ? $model->getImageUrl() : '#',
                    $model->title,
                    [
                        'class' => 'preview-image img-responsive',
                        'style' => !$model->getIsNewRecord() && $model->image ? '' : 'display:none',
                    ]
                ); ?>

                <?php if (!$model->getIsNewRecord() && $model->image): ?>
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
            <div class="col-sm-12 form-group popover-help"
                 data-original-title='<?= $model->getAttributeLabel('content'); ?>'
                 data-content='<?= $model->getAttributeDescription('content'); ?>'>
                <?= $form->labelEx($model, 'content'); ?>
                <?php
                $this->widget(
                    $this->module->getVisualEditor(),
                    [
                        'model' => $model,
                        'attribute' => 'content'
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 form-group popover-help"
                 data-original-title='<?= $model->getAttributeLabel('quote'); ?>'
                 data-content='<?= $model->getAttributeDescription('quote'); ?>'>
                <?= $form->labelEx($model, 'quote'); ?>
                <?php
                $this->widget(
                    $this->module->getVisualEditor(),
                    [
                        'model' => $model,
                        'attribute' => 'quote',
                    ]
                ); ?>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="seo">
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup(
                    $model,
                    'meta_title',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('meta_title'),
                                'data-content' => $model->getAttributeDescription('meta_title'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textFieldGroup(
                    $model,
                    'meta_keywords',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('meta_keywords'),
                                'data-content' => $model->getAttributeDescription('meta_keywords'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-7">
                <?= $form->textAreaGroup(
                    $model,
                    'meta_description',
                    [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'class' => 'popover-help',
                                'data-original-title' => $model->getAttributeLabel('meta_description'),
                                'data-content' => $model->getAttributeDescription('meta_description'),
                            ],
                        ],
                    ]
                ); ?>
            </div>
        </div>

    </div>
</div>
<br/>

<?php if (!$model->getIsNewRecord() && !$model->isPublished()): ?>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'id' => 'post-publish',
            'buttonType' => 'submit',
            'context' => 'success',
            'label' => Yii::t('BlogModule.blog', 'Publish'),
            'htmlOptions' => [
                'name' => 'post-publish',
            ],
        ]
    );
    ?>

<?php endif; ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => $model->getIsNewRecord() ? Yii::t('BlogModule.blog', 'Create post and continue') : Yii::t(
            'BlogModule.blog',
            'Save post and continue'
        ),
    ]
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label' => $model->getIsNewRecord() ? Yii::t('BlogModule.blog', 'Create post and close') : Yii::t(
            'BlogModule.blog',
            'Save post and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>

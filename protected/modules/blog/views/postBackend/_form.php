<?php
/**
 * Отображение для postBackend/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 *
 * @var $form \yupe\widgets\ActiveForm
 * @var $model Post
 * @var $this PostController
 **/
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'post-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
);

?>
<div class="alert alert-info">
    <?php echo Yii::t('BlogModule.blog', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('BlogModule.blog', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->select2Group(
            $model,
            'blog_id',
            [
                'widgetOptions' => [
                    'data' => ['' => '---'] + CHtml::listData(Blog::model()->getList(), 'id', 'name'),
                ]
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
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
        <?php echo $form->dateTimePickerGroup(
            $model,
            'publish_time',
            [
                'widgetOptions' => [
                    'options'     => [
                        'format'    => 'dd-mm-yyyy hh:ii',
                        'weekStart' => 1,
                        'autoclose' => true,
                    ],
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('publish_time'),
                        'data-content'        => $model->getAttributeDescription('publish_time'),
                    ],
                ],
                'prepend'       => '<i class="fa fa-calendar"></i>',
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'title',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('title'),
                        'data-content'        => $model->getAttributeDescription('title')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->slugFieldGroup(
            $model,
            'slug',
            [
                'sourceAttribute' => 'title',
                'widgetOptions'   => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('slug'),
                        'data-content'        => $model->getAttributeDescription('slug')
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
            'link',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('link'),
                        'data-content'        => $model->getAttributeDescription('link')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-5">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'tags', ['control-label']); ?>
            <?php
            $this->widget(
                'booster.widgets.TbSelect2',
                [
                    'asDropDownList' => false,
                    'name'           => 'tags',
                    'options'        => [
                        'tags'        => array_values(CHtml::listData(Tag::model()->findAll(), 'id', 'name')),
                        'placeholder' => Yii::t('BlogModule.blog', 'tags'),
                    ],
                    'value'          => implode(", ", $model->getTags()),
                    'htmlOptions'    => [
                        'class'               => 'form-control popover-help',
                        'data-original-title' => $model->getAttributeLabel('tags'),
                        'data-content'        => $model->getAttributeDescription('tags')
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
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->title,
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
<div class="row">
    <div class="col-sm-12 form-group popover-help"
         data-original-title='<?php echo $model->getAttributeLabel('content'); ?>'
         data-content='<?php echo $model->getAttributeDescription('content'); ?>'>
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php
        $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'content',
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group popover-help"
         data-original-title='<?php echo $model->getAttributeLabel('quote'); ?>'
         data-content='<?php echo $model->getAttributeDescription('quote'); ?>'>
        <?php echo $form->labelEx($model, 'quote'); ?>
        <?php
        $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'quote',
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#blog_post_additional">
                        <?php echo Yii::t('BlogModule.blog', 'Дополнительно'); ?>
                    </a>
                </h4>
            </div>
            <div id="blog_post_additional" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-2">
                            <?php echo $form->dropDownListGroup(
                                $model,
                                'category_id',
                                [
                                    'widgetOptions' => [
                                        'data'        => Category::model()->getFormattedList(
                                            (int)Yii::app()->getModule('blog')->mainPostCategory
                                        ),
                                        'htmlOptions' => [
                                            'empty'               => Yii::t('BlogModule.blog', '--choose--'),
                                            'class'               => 'popover-help',
                                            'data-original-title' => $model->getAttributeLabel('category_id'),
                                            'data-content'        => $model->getAttributeDescription('category_id'),
                                            'data-container'      => "body",
                                        ],
                                    ],
                                ]
                            ); ?>
                        </div>
                        <div class="col-sm-2">
                            <?php echo $form->dropDownListGroup(
                                $model,
                                'access_type',
                                [
                                    'widgetOptions' => [
                                        'data'        => $model->getAccessTypeList(),
                                        'htmlOptions' => [
                                            'class'               => 'popover-help',
                                            'data-original-title' => $model->getAttributeLabel('access_type'),
                                            'data-content'        => $model->getAttributeDescription('access_type'),
                                            'data-container'      => "body",
                                        ],
                                    ],
                                ]
                            ); ?>
                        </div>
                        <div class="col-sm-2">
                            <?php echo $form->dropDownListGroup(
                                $model,
                                'comment_status',
                                [
                                    'widgetOptions' => [
                                        'data'        => $model->getCommentStatusList(),
                                        'htmlOptions' => [
                                            'class'               => 'popover-help',
                                            'data-original-title' => $model->getAttributeLabel('comment_status'),
                                            'data-content'        => $model->getAttributeDescription('comment_status'),
                                            'data-container'      => "body",
                                        ],
                                    ],
                                ]
                            ); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">
                    <a data-toggle="collapse" data-parent="#accordion" href="#blog_post_seodata">
                        <?php echo Yii::t('BlogModule.blog', 'Data for SEO'); ?>
                    </a>
                </h4>
            </div>
            <div id="blog_post_seodata" class="panel-collapse collapse">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-7">
                            <?php echo $form->textFieldGroup(
                                $model,
                                'keywords',
                                [
                                    'widgetOptions' => [
                                        'htmlOptions' => [
                                            'class'               => 'popover-help',
                                            'data-original-title' => $model->getAttributeLabel('keywords'),
                                            'data-content'        => $model->getAttributeDescription('keywords'),
                                        ],
                                    ],
                                ]
                            ); ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-7">
                            <?php echo $form->textAreaGroup(
                                $model,
                                'description',
                                [
                                    'widgetOptions' => [
                                        'htmlOptions' => [
                                            'class'               => 'popover-help',
                                            'data-original-title' => $model->getAttributeLabel('description'),
                                            'data-content'        => $model->getAttributeDescription('description'),
                                        ],
                                    ],
                                ]
                            ); ?>
                        </div>
                    </div>
                </div>
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
            'id'          => 'post-publish',
            'buttonType'  => 'submit',
            'context'     => 'success',
            'label'       => Yii::t('BlogModule.blog', 'Publish'),
            'htmlOptions' => [
                'name' => 'post-publish'
            ]
        ]
    );
    ?>

<?php endif; ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create post and continue') : Yii::t(
            'BlogModule.blog',
            'Save post and continue'
        ),
    ]
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create post and close') : Yii::t(
            'BlogModule.blog',
            'Save post and close'
        ),
    ]
); ?>

<?php $this->endWidget(); ?>

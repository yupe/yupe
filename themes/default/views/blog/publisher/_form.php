<script type='text/javascript'>
    $(document).ready(function () {
        $('#post-write').liTranslit({
            elName: '#Post_title',
            elAlias: '#Post_slug'
        });
    })
</script>


<?php
/**
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'post-write',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
);

?>

<div class="alert alert-info">
    Вы можете писать только в блоги, подписчиком которых являетесь...
</div>

<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-2">
        <?= $form->select2Group(
            $model,
            'blog_id',
            [
                'widgetOptions' => [
                    'data' => ['' => '---'] + CHtml::listData($blogs,
                            'id',
                            'name'
                        ),
                ]
            ]
        );?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?= $form->textFieldGroup(
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
    <div class="col-sm-12">
        <?= $form->textFieldGroup(
            $model,
            'slug',
            [
                'widgetOptions' => [
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
    <script type="text/javascript">
        $(document).ready(function () {
            $("#tags").val('<?= join(',',$model->getTags());?>');
        });
    </script>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?=
            CHtml::image(
            !$model->getIsNewRecord() && $model->image ? $model->getImageUrl() : '#',
            $model->title,
            [
                'class' => 'preview-image',
                'style' => !$model->getIsNewRecord() && $model->image ? '' : 'display:none'
            ]
        ); ?>
        <?= $form->fileFieldGroup(
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
    <div class="col-sm-12 form-group popover-help <?= $model->hasErrors('content') ? 'has-error' : ''; ?>"
         data-original-title='<?= $model->getAttributeLabel('content'); ?>'
         data-content='<?= $model->getAttributeDescription('content'); ?>'>
        <?php
        echo $form->labelEx($model, 'content', ['class' => 'control-label']);

        $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'content',
                'options' => [
                    'imageUpload' => Yii::app()->createUrl('/blog/publisher/imageUpload'),
                    'fileUpload' => false,
                    'imageManagerJson' => false,
                ]
            ]
        );

        echo $form->error($model, 'content', ['class' => 'help-block error']);
        ?>

    </div>
</div>

<div class="row">
    <div class="col-sm-12 form-group popover-help <?= $model->hasErrors('quote') ? 'has-error' : ''; ?>"
         data-original-title='<?= $model->getAttributeLabel('quote'); ?>'
         data-content='<?= $model->getAttributeDescription('quote'); ?>'>
        <?php
        echo $form->labelEx($model, 'quote', ['class' => 'control-label']);

        $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'quote',
            ]
        );

        echo $form->error($model, 'quote', ['class' => 'help-block error']);
        ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <?= $form->labelEx($model, 'tags', ['class' => 'control-label']); ?>
            <?php
            $this->widget(
                'booster.widgets.TbSelect2',
                [
                    'asDropDownList' => false,
                    'name'           => 'tags',
                    'options'        => [
                        'tags'            => array_values(CHtml::listData(Tag::model()->findAll(), 'id', 'name')),
                        'placeholder'     => Yii::t('BlogModule.blog', 'tags'),
                        'tokenSeparators' => [',', ' ']
                    ],
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

<div class="row">
    <div class="col-sm-12">
        <?= $form->textFieldGroup(
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

<div class="alert alert-info">
    После публикации записи ее редактирование будет невозможно!
</div>

<br/>

<button name="publish" class="btn btn-primary" id="publish-post" type="submit">Опубликовать</button>

<button name="draft" class="btn btn-default" id="draft-post" type="submit">Сохранить черновик</button>

<?php $this->endWidget(); ?>

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
    array(
        'id'                     => 'post-write',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
);

?>

<div class="alert alert-info">
    Вы можете писать только в блоги, подписчиком которых являетесь...
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-2">
        <?php echo $form->select2Group(
            $model,
            'blog_id',
            array(
                'widgetOptions' => array(
                    'data' => ['' => '---'] + CHtml::listData($blogs,
                            'id',
                            'name'
                        ),
                )
            )
        );?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php echo $form->textFieldGroup(
            $model,
            'title',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('title'),
                        'data-content'        => $model->getAttributeDescription('title')
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php echo $form->textFieldGroup(
            $model,
            'slug',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('slug'),
                        'data-content'        => $model->getAttributeDescription('slug')
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <script type="text/javascript">
        $(document).ready(function () {
            $("#tags").val('<?php echo join(',',$model->getTags());?>');
        });
    </script>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php
        echo CHtml::image(
            !$model->isNewRecord && $model->image ? $model->getImageUrl() : '#',
            $model->title,
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

<div class="row">
    <div class="col-sm-12 form-group popover-help"
         data-original-title='<?php echo $model->getAttributeLabel('content'); ?>'
         data-content='<?php echo $model->getAttributeDescription('content'); ?>'>
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php
        $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'content',
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'tags', array('control-label')); ?>
            <?php
            $this->widget(
                'booster.widgets.TbSelect2',
                array(
                    'asDropDownList' => false,
                    'name'           => 'tags',
                    'options'        => array(
                        'tags'            => array_values(CHtml::listData(Tag::model()->findAll(), 'id', 'name')),
                        'placeholder'     => Yii::t('BlogModule.blog', 'tags'),
                        'tokenSeparators' => array(',', ' ')
                    ),
                    'htmlOptions'    => array(
                        'class'               => 'form-control popover-help',
                        'data-original-title' => $model->getAttributeLabel('tags'),
                        'data-content'        => $model->getAttributeDescription('tags')
                    ),
                )
            ); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <?php echo $form->textFieldGroup(
            $model,
            'link',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('link'),
                        'data-content'        => $model->getAttributeDescription('link')
                    ),
                ),
            )
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

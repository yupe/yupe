<script type='text/javascript'>
    $(document).ready(function () {
        $('#post-write').liTranslit({
            elName:  '#Post_title',
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
    'bootstrap.widgets.TbActiveForm', array(
        'id' => 'post-write',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
        'inlineErrors' => true,
    )
);

?>

<div class="alert alert-info">
    Вы можете писать только  в блоги, подписчиком которых являетесь...
</div>

<?php echo $form->errorSummary($model);?>

<div class="row-fluid control-group">
    <div class="span2 pull-left">
        <?php echo $form->labelEx($model, 'blog_id'); ?>
        <?php
            $this->widget(
                'bootstrap.widgets.TbSelect2', array(
                    'asDropDownList' => true,
                    'model' => $model,
                    'attribute' => 'blog_id',
                    'data' => CHtml::listData($blogs, 'id', 'name'),
                    'options' => array(
                        'placeholder' => 'blog'
                    )
                )
            );
        ?>
    </div>
</div>

<div class="row-fluid control-group <?php echo $model->hasErrors('title') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span12 popover-help', 'maxlength' => 250, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
</div>

<div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'slug', array('class' => 'span12 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
</div>

<div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">
    <script type="text/javascript">
        $(document).ready(function () {
            $("#tags").val('<?php echo join(',',$model->getTags());?>');
        });
    </script>
</div>

<div class="row-fluid control-group <?php echo $model->hasErrors('image') ? 'error' : ''; ?>">
    <div class="span7  popover-help" data-original-title="<?php echo $model->getAttributeLabel('image'); ?>">
        <?php
            echo CHtml::image(
                !$model->isNewRecord && $model->image
                    ? $model->getImageUrl()
                    : '#',
                $model->title, array(
                    'class' => 'preview-image',
                    'style' => !$model->isNewRecord && $model->image
                            ? ''
                            : 'display:none'
                )
            );
        ?>
        <?php echo $form->labelEx($model, 'image'); ?>
        <?php echo $form->fileField($model, 'image', array('onchange' => 'readURL(this);')); ?>
    </div>
    <div class="span5">
        <?php echo $form->error($model, 'image'); ?>
    </div>
</div>


<div class="row-fluid control-group <?php echo $model->hasErrors('content') ? 'error' : ''; ?>">
    <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('content'); ?>'
         data-content='<?php echo $model->getAttributeDescription('content'); ?>'>
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php
            $this->widget(
                $this->module->editor, array(
                    'model' => $model,
                    'attribute' => 'content',
                    'options' => $this->module->editorOptions,
                )
            );
        ?>
    </div>
</div>

<div class="popover-help row-fluid control-group" data-original-title='<?php echo $model->getAttributeLabel('tags'); ?>'
     data-content='<?php echo $model->getAttributeDescription('tags'); ?>'>
    <?php echo $form->labelEx($model, 'tags'); ?>
    <?php
        $this->widget(
            'bootstrap.widgets.TbSelect2', array(
                'asDropDownList' => false,
                'name' => 'tags',
                'options' => array(
                    'tags' => array_values(CHtml::listData(Tag::model()->findAll(), 'id', 'name')),
                    'placeholder' => Yii::t('BlogModule.blog', 'tags'),
                    'width' => '100%',
                    'tokenSeparators' => array(',', ' ')
                )
            )
        );
    ?>
</div>

<div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'link', array('class' => 'span12 popover-help', 'maxlength' => 250, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('link'), 'data-content' => $model->getAttributeDescription('link'))); ?>
</div>

<div class="alert alert-info">
    После публикации записи ее редактирование будет невозможно!
</div>

<br/>

<button name="publish" class="btn btn-primary" id="publish-post" type="submit">Опубликовать</button>

<button name="draft" class="btn" id="draft-post" type="submit">Сохранить черновик</button>

<?php $this->endWidget(); ?>
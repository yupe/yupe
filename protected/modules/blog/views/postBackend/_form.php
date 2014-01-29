<script type='text/javascript'>
    $(document).ready(function () {
        $('#post-form').liTranslit({
            elName: '#Post_title',
            elAlias: '#Post_slug'
        });
    })
</script>

<?php
/**
 * Отображение для postBackend/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'id' => 'post-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well', 'enctype' => 'multipart/form-data'),
        'inlineErrors' => true,
    )
);

?>
<div class="alert alert-info">
    <?php echo Yii::t('BlogModule.blog', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('BlogModule.blog', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row-fluid control-grou">
    <div class="span2 pull-left">
        <?php echo $form->labelEx($model, 'blog_id'); ?>
        <?php
        $this->widget(
            'bootstrap.widgets.TbSelect2', array(
                'asDropDownList' => true,
                'model' => $model,
                'attribute' => 'blog_id',
                'data' => CHtml::listData(Blog::model()->getList(), 'id', 'name'),
                'val' => null
            )
        );
        ?>
    </div>

    <div class="span2  pull-left">
        <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
    </div>

    <div class="span2  pull-left popover-help" data-original-title='<?php echo $model->getAttributeLabel('publish_date'); ?>'
         data-content='<?php echo $model->getAttributeDescription('publish_date'); ?>'>
        <?php
        echo $form->datetimepickerRow(
            $model, 'publish_date', array(
                'options' => array(
                    'format' => 'dd-mm-yyyy hh:ii',
                    'weekStart' => 1,
                    'autoclose' => true
                ),
            )
        ); ?>
    </div>

</div>

<div class="row-fluid control-group <?php echo $model->hasErrors('title') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'title', array('class' => 'span7 popover-help', 'maxlength' => 250, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('slug') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'slug', array('class' => 'span7 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">
    <?php echo $form->textFieldRow($model, 'link', array('class' => 'span7 popover-help', 'maxlength' => 250, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('link'), 'data-content' => $model->getAttributeDescription('link'))); ?>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('link') ? 'error' : ''; ?>">

    <script type="text/javascript">
        $(document).ready(function () {
            $("#tags").val('<?php echo join(',',$model->getTags());?>');
        });
    </script>

    <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('tags'); ?>'
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
                    'width' => '40%',
                    'tokenSeparators' => array(',', ' ')
                )
            )
        );
        ?>
    </div>
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
        ); ?>
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
        ); ?>
    </div>
</div>
<div class="row-fluid control-group <?php echo $model->hasErrors('quote') ? 'error' : ''; ?>">
    <div class="popover-help" data-original-title='<?php echo $model->getAttributeLabel('quote'); ?>'
         data-content='<?php echo $model->getAttributeDescription('quote'); ?>'>
        <?php echo $form->labelEx($model, 'quote'); ?>
        <?php
        $this->widget(
            $this->module->editor, array(
                'model' => $model,
                'attribute' => 'quote',
                'options' => $this->module->editorOptions,
            )
        ); ?>
    </div>
</div>

<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>

<div class="accordion-group">
    <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseTwo">
            <?php echo Yii::t('BlogModule.blog', 'Дополнительно'); ?>
        </a>
    </div>
    <div id="collapseTwo" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="row-fluid control-group <?php echo $model->hasErrors('category_id') ? 'error' : ''; ?>">
                <?php echo $form->dropDownListRow($model, 'category_id', Category::model()->getFormattedList((int)Yii::app()->getModule('blog')->mainPostCategory), array('empty' => Yii::t('BlogModule.blog', '--choose--'), 'class' => 'popover-help span7', 'maxlength' => 11, 'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'))); ?>
            </div>
            <div
                class="wide row-fluid control-group <?php echo ($model->hasErrors('status') || $model->hasErrors('comment_status') || $model->hasErrors('access_type')) ? 'error' : ''; ?>">

                <div class="span2">
                    <?php echo $form->dropDownListRow($model, 'access_type', $model->getAccessTypeList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('access_type'), 'data-content' => $model->getAttributeDescription('access_type'))); ?>
                </div>
                <div class="span2">
                    <br/><br/>
                    <?php echo $form->checkBoxRow($model, 'comment_status', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('comment_status'), 'data-content' => $model->getAttributeDescription('comment_status'))); ?>
                </div>
            </div>
        </div>
    </div>

</div>

<?php $this->endWidget(); ?>


<?php $collapse = $this->beginWidget('bootstrap.widgets.TbCollapse'); ?>
<div class="accordion-group">
    <div class="accordion-heading">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
            <?php echo Yii::t('BlogModule.blog', 'Data for SEO'); ?>
        </a>
    </div>
    <div id="collapseOne" class="accordion-body collapse">
        <div class="accordion-inner">
            <div class="row-fluid control-group <?php echo $model->hasErrors('keywords') ? 'error' : ''; ?>">
                <?php echo $form->textFieldRow($model, 'keywords', array('size' => 60, 'maxlength' => 250, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('keywords'), 'data-content' => $model->getAttributeDescription('keywords'))); ?>
            </div>
            <div class="row-fluid control-group <?php echo $model->hasErrors('description') ? 'error' : ''; ?>">
                <?php echo $form->textAreaRow($model, 'description', array('rows' => 3, 'cols' => 98, 'class' => 'span7 popover-help', 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

<br/>

<?php
$this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'type' => 'primary',
        'label' => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create post and continue') : Yii::t('BlogModule.blog', 'Save post and continue'),
    )
); ?>
<?php
$this->widget(
    'bootstrap.widgets.TbButton', array(
        'buttonType' => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label' => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create post and close') : Yii::t('BlogModule.blog', 'Save post and close'),
    )
); ?>

<?php $this->endWidget(); ?>
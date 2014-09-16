<script type='text/javascript'>
    $(document).ready(function () {
        $('#blog-form').liTranslit({
            elName: '#Blog_name',
            elAlias: '#Blog_slug'
        });
    })
</script>


<?php
/**
 * Отображение для BlogBackend/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'blog-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
);

?>
<div class="alert alert-info">
    <?php echo Yii::t('BlogModule.blog', 'Fields marked with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('BlogModule.blog', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            array(
                'widgetOptions' => array(
                    'data'        => Category::model()->getFormattedList(
                            (int)Yii::app()->getModule('blog')->mainCategory
                        ),
                    'htmlOptions' => array(
                        'empty'               => Yii::t('BlogModule.blog', '--choose--'),
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('category_id'),
                        'data-content'        => $model->getAttributeDescription('category_id'),
                        'encode'              => false
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getTypeList(),
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('type'),
                        'data-content'        => $model->getAttributeDescription('type'),
                    ),
                ),
            )
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('status'),
                        'data-content'        => $model->getAttributeDescription('status'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'member_status',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getMemberStatusList(),
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('member_status'),
                        'data-content'        => $model->getAttributeDescription('member_status'),
                    ),
                ),
            )
        ); ?>
    </div>
    <div class="col-sm-4">
        <?php echo $form->dropDownListGroup(
            $model,
            'post_status',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getPostStatusList(),
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('post_status'),
                        'data-content'        => $model->getAttributeDescription('post_status'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php
        echo $form->textFieldGroup(
            $model,
            'name',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('name'),
                        'data-content'        => $model->getAttributeDescription('name'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup(
            $model,
            'slug',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('slug'),
                        'data-content'        => $model->getAttributeDescription('slug'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php
        echo CHtml::image(
            $model->getImageUrl(),
            $model->name,
            array(
                'class' => 'preview-image',
            )
        ); ?>
        <?php echo $form->fileFieldGroup(
            $model,
            'icon',
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
         data-original-title='<?php echo $model->getAttributeLabel('description'); ?>'
         data-content='<?php echo $model->getAttributeDescription(
             'description'
         ); ?>'>
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php
        $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model'     => $model,
                'attribute' => 'description',
            )
        ); ?>
    </div>
</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create blog and continue') : Yii::t(
                'BlogModule.blog',
                'Save blog and continue'
            ),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Create blog and close') : Yii::t(
                'BlogModule.blog',
                'Save blog and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>

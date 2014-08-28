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
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'user-to-blog-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well'),
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
            'user_id',
            array(
                'widgetOptions' => array(
                    'data'        => CHtml::listData(User::model()->findAll(), 'id', 'nick_name'),
                    'htmlOptions' => array(
                        'class'               => 'span7 popover-help',
                        'data-original-title' => $model->getAttributeLabel('user_id'),
                        'data-content'        => $model->getAttributeDescription('user_id'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'blog_id',
            array(
                'widgetOptions' => array(
                    'data'        => CHtml::listData(Blog::model()->findAll(), 'id', 'name'),
                    'htmlOptions' => array(
                        'class'               => 'span7 popover-help',
                        'data-original-title' => $model->getAttributeLabel('blog_id'),
                        'data-content'        => $model->getAttributeDescription('blog_id'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'role',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getRoleList(),
                    'htmlOptions' => array(
                        'class'               => 'span7 popover-help',
                        'data-original-title' => $model->getAttributeLabel('role'),
                        'data-content'        => $model->getAttributeDescription('role'),
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            array(
                'widgetOptions' => array(
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => array(
                        'class'               => 'span7 popover-help',
                        'data-original-title' => $model->getAttributeLabel('status'),
                        'data-content'        => $model->getAttributeDescription('status'),
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
            'note',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'class'               => 'popover-help',
                        'data-original-title' => $model->getAttributeLabel('note'),
                        'data-content'        => $model->getAttributeDescription('note')
                    ),
                ),
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
        'label'      => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Add member and continue') : Yii::t(
                'BlogModule.blog',
                'Save member and continue'
            ),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t('BlogModule.blog', 'Add member and close') : Yii::t(
                'BlogModule.blog',
                'Save member and close'
            ),
    )
); ?>

<?php $this->endWidget(); ?>

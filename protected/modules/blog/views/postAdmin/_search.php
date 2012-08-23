<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well form-vertical'),
));

Yii::app()->clientScript->registerScript('fieldset', "
    $('document').ready(function () {
        $('.popover-help').popover({ 'delay' : 500 });
    });
");
?>

    <fieldset class="inline">
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'id', array('class' => 'span3 popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'blog_id', CHtml::listData(Blog::model()->findAll(), 'id', 'name'), array('empty'=>Yii::t('blog', 'выберите блог'), 'class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('blog_id'), 'data-content' => $model->getAttributeDescription('blog_id'))); ?>
            </div>
            <?php /*
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'create_user_id', array('class' => 'span3 popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('create_user_id'), 'data-content' => $model->getAttributeDescription('create_user_id'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'update_user_id', array('class' => 'span3 popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('update_user_id'), 'data-content' => $model->getAttributeDescription('update_user_id'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'create_date', array('class' => 'span3 popover-help', 'maxlength' => 11, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('create_date'), 'data-content' => $model->getAttributeDescription('create_date'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'update_date', array('class' => 'span3 popover-help', 'maxlength' => 11, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('update_date'), 'data-content' => $model->getAttributeDescription('update_date'))); ?>
            </div>
            */ ?>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'slug', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->labelEx($model, 'publish_date'); ?>
                <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'publish_date',
                    'options' => array('dateFormat' => 'yy-mm-dd'),
                )); ?>
                <br />
                <?php $this->widget('bootstrap.widgets.TbLabel', array('type'=>'info', 'label'=>$model->getAttributeDescription('publish_date'))); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'title', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'quote', array('class' => 'span3 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('quote'), 'data-content' => $model->getAttributeDescription('quote'))); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'content', array('class' => 'span3 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('content'), 'data-content' => $model->getAttributeDescription('content'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'link', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('link'), 'data-content' => $model->getAttributeDescription('link'))); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->checkBoxRow($model, 'comment_status', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('comment_status'), 'data-content' => $model->getAttributeDescription('comment_status'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->dropDownList($model, 'access_type', $model->getAccessTypeList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('access_type'), 'data-content' => $model->getAttributeDescription('access_type'))); ?>
            </div>
        </div>
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'keywords', array('class' => 'span3 popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('keywords'), 'data-content' => $model->getAttributeDescription('keywords'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'description', array('class' => 'span3 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
            </div>
        </div>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('blog', 'Искать запись'),
    )); ?>

<?php $this->endWidget(); ?>
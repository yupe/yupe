<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
    'action'      => Yii::app()->createUrl($this->route),
    'method'      => 'get',
    'type'        => 'vertical',
    'htmlOptions' => array('class' => 'well'),
)); ?>

    <fieldset class="inline">
        <div class="wide row-fluid control-group">
            <div class="span1">
                <?php echo $form->textFieldRow($model, 'id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 11, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
            </div>
            <div class="span3">
                <br /><br />
                <?php echo $form->checkBoxRow($model, 'is_special', array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('is_special'), 'data-content' => $model->getAttributeDescription('is_special'))); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <div class="span7">
                <?php echo $form->dropDownListRow($model, 'category_id', CHtml::listData(Category::model()->findAll(), 'id', 'name'), array('empty' => Yii::t('CatalogModule.catalog', '--choose--'), 'class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('category_id'), 'data-content' => $model->getAttributeDescription('category_id'))); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <div class="span4">
                <?php echo $form->textFieldRow($model, 'name', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'alias', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('alias'), 'data-content' => $model->getAttributeDescription('alias'))); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <div class="span4">
                <?php echo $form->textFieldRow($model, 'price', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('price'), 'data-content' => $model->getAttributeDescription('price'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'article', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 100, 'data-original-title' => $model->getAttributeLabel('article'), 'data-content' => $model->getAttributeDescription('article'))); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <?php /*
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'image', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 300, 'data-original-title' => $model->getAttributeLabel('image'), 'data-content' => $model->getAttributeDescription('image'))); ?>
            </div>
            */ ?>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'short_description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('short_description'), 'data-content' => $model->getAttributeDescription('short_description'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'data', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('data'), 'data-content' => $model->getAttributeDescription('data'))); ?>
            </div>
            <?php /*
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'create_time', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('create_time'), 'data-content' => $model->getAttributeDescription('create_time'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'update_time', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('update_time'), 'data-content' => $model->getAttributeDescription('update_time'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'user_id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('user_id'), 'data-content' => $model->getAttributeDescription('user_id'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'change_user_id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 10, 'data-original-title' => $model->getAttributeLabel('change_user_id'), 'data-content' => $model->getAttributeDescription('change_user_id'))); ?>
            </div>
             */ ?>
        </div>
    </fieldset>

    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'        => 'primary',
        'encodeLabel' => false,
        'buttonType'  => 'submit',
        'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('CatalogModule.catalog', 'Find a product'),
    )); ?>

<?php $this->endWidget(); ?>

<?php
/**
 * Отображение для blogAdmin/_search:
 * 
 *   @category YupeView
 *   @package  YupeCMS
 *   @author   Yupe Team <team@yupe.ru>
 *   @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 *   @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
);

?>

    <fieldset class="inline">
        <div class="wide row-fluid control-group">
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'id', array('class' => 'popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'slug', array('class' => 'popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'name', array('class' => 'popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('type'), 'data-content' => $model->getAttributeDescription('type'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
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
            <?php /*
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'icon', array('class' => 'span3 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('icon'), 'data-content' => $model->getAttributeDescription('icon'))); ?>
            </div>
             */ ?>
            <?php echo $form->textFieldRow($model, 'description', array('class' => 'span7 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
        </div>
    </fieldset>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('BlogModule.blog', 'Искать блог'),
        )
    ); ?>

<?php $this->endWidget(); ?>
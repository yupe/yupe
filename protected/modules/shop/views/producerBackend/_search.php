<?php
/**
 * Отображение для _search:
 *
 *   @category YupeView
 *   @package  yupe
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
        <div class="row-fluid control-group">
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'id', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'title_short', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('title_short'), 'data-content' => $model->getAttributeDescription('title_short'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'title', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('title'), 'data-content' => $model->getAttributeDescription('title'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'slug', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 150, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'status', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'order', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 60, 'data-original-title' => $model->getAttributeLabel('order'), 'data-content' => $model->getAttributeDescription('order'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'image', array('class' => 'span3 popover-help', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('image'), 'data-content' => $model->getAttributeDescription('image'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textAreaRow($model, 'short_description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('short_description'), 'data-content' => $model->getAttributeDescription('short_description'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textAreaRow($model, 'description', array('class' => 'span5 popover-help', 'rows' => 6, 'cols' => 50, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
            </div>
        </div>
    </fieldset>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('producer', 'Искать Производителя'),
        )
    ); ?>

<?php $this->endWidget(); ?>
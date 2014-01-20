<?php
/**
 * Отображение для blogBackend/_search:
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
        <div class="wide row-fluid control-group">          
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'slug', array('class' => 'popover-help', 'maxlength' => 150, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('slug'), 'data-content' => $model->getAttributeDescription('slug'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'name', array('class' => 'popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('name'), 'data-content' => $model->getAttributeDescription('name'))); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'type', $model->getTypeList(), array('empty' => '----', 'class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('type'), 'data-content' => $model->getAttributeDescription('type'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('empty' => '----', 'class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
            </div>            
        </div>
        <div class="row-fluid control-group">            
            <?php echo $form->textFieldRow($model, 'description', array('class' => 'span7 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('description'), 'data-content' => $model->getAttributeDescription('description'))); ?>
        </div>
    </fieldset>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('BlogModule.blog', 'Find a blog'),
        )
    ); ?>

<?php $this->endWidget(); ?>
<?php
/**
 * Отображение для postBackend/_search:
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
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'id', array('class' => 'span2 popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->dropDownListRow($model, 'role', $model->getRoleList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('role'), 'data-content' => $model->getAttributeDescription('role'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'status', $model->getStatusList(), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('status'), 'data-content' => $model->getAttributeDescription('status'))); ?>
            </div>
        </div>
        <div class="wide row-fluid control-group">
            <div class="span4">
                <?php echo $form->dropDownListRow($model, 'user_id', CHtml::listData(User::model()->findAll(), 'id', 'nick_name'), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('user_id'), 'data-content' => $model->getAttributeDescription('user_id'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'blog_id', CHtml::listData(Blog::model()->findAll(), 'id', 'name'), array('class' => 'span3 popover-help', 'data-original-title' => $model->getAttributeLabel('blog_id'), 'data-content' => $model->getAttributeDescription('blog_id'))); ?>
            </div>
        </div>
        <?php /*
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'create_date', array('class' => 'span3 popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('create_date'), 'data-content' => $model->getAttributeDescription('create_date'))); ?>
            </div>
            <div class="span2">
                <?php echo $form->textFieldRow($model, 'update_date', array('class' => 'span3 popover-help', 'maxlength' => 10, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('update_date'), 'data-content' => $model->getAttributeDescription('update_date'))); ?>
            </div>
             */ ?>
        <div class="row-fluid control-group">
            <?php echo $form->textFieldRow($model, 'note', array('class' => 'span7 popover-help', 'maxlength' => 300, 'size' => 60, 'data-original-title' => $model->getAttributeLabel('note'), 'data-content' => $model->getAttributeDescription('note'))); ?>
        </div>
    </fieldset>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('BlogModule.blog', 'Find a member'),
        )
    ); ?>

<?php $this->endWidget(); ?>
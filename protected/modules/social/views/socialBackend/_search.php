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
            <div class="span3">
                <?php echo $form->dropDownListRow($model, 'user_id', CHtml::listData(User::model()->findAll(), 'id', 'fullName'), array('empty' => '---')); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'provider', array('class' => 'popover-help', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('provider'), 'data-content' => $model->getAttributeDescription('provider'))); ?>
            </div>
            <div class="span3">
                <?php echo $form->textFieldRow($model, 'uid', array('class' => 'popover-help', 'size' => 60, 'maxlength' => 250, 'data-original-title' => $model->getAttributeLabel('uid'), 'data-content' => $model->getAttributeDescription('uid'))); ?>
            </div>
        </div>
    </fieldset>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', array(
            'type'        => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="icon-search icon-white">&nbsp;</i> ' . Yii::t('SocialModule.social', 'Искать аккаунт'),
        )
    ); ?>

<?php $this->endWidget(); ?>
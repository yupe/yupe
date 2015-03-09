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
    'bootstrap.widgets.TbActiveForm', [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'type'        => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
);
?>

<fieldset>
    <div class="row">
                    <div class="col-sm-3">
                <?php echo $form->textFieldGroup($model, 'id', ['widgetOptions' => ['htmlOptions' => ['class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('id'), 'data-content' => $model->getAttributeDescription('id')]]]); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->dropDownListGroup($model, 'user_id', ['widgetOptions' => ['data' => CHtml::listData(User::model()->findAll(), 'id', 'first_name')]]); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->textFieldGroup($model, 'my_post', ['widgetOptions' => ['htmlOptions' => ['class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('my_post'), 'data-content' => $model->getAttributeDescription('my_post')]]]); ?>
            </div>
            <div class="col-sm-3">
                <?php echo $form->textFieldGroup($model, 'my_comment', ['widgetOptions' => ['htmlOptions' => ['class' => 'popover-help', 'data-original-title' => $model->getAttributeLabel('my_comment'), 'data-content' => $model->getAttributeDescription('my_comment')]]]); ?>
            </div>
    </div>
</fieldset>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton', [
            'context'     => 'primary',
            'encodeLabel' => false,
            'buttonType'  => 'submit',
            'label'       => '<i class="fa fa-search">&nbsp;</i> ' . Yii::t('NotifyModule.notify', 'Search'),
        ]
    ); ?>

<?php $this->endWidget(); ?>
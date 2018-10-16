<?php
/**
 * Отображение для _search:
 *
 * @category YupeView
 * @package  yupe
 * @author   Yupe Team <team@yupe.ru>
 * @license  https://github.com/yupe/yupe/blob/master/LICENSE BSD
 * @link     http://yupe.ru
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'action'      => Yii::app()->createUrl($this->route),
        'method'      => 'get',
        'htmlOptions' => ['class' => 'well search-form'],
    ]
); ?>

<fieldset>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'code'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-7">
            <?php echo $form->textAreaGroup($model, 'description'); ?>
        </div>
    </div>
    <div class="form-actions">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType'  => 'submit',
                'context'     => 'primary',
                'encodeLabel' => false,
                'label'       => '<i class="fa fa-search"></i> ' . Yii::t('MailModule.mail', 'Find')
            ]
        ); ?>
    </div>
</fieldset>
<?php $this->endWidget(); ?>

<?php
/**
 * @var TbActiveForm $form
 */

$this->title = Yii::t('UserModule.user', 'Password recovery');
$this->breadcrumbs = [Yii::t('UserModule.user', 'Password recovery')];
?>
<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'registration-form',
        'type' => 'vertical',
        'htmlOptions' => [
            'class' => 'well',
        ]
    ]
); ?>

<?= $form->errorSummary($model); ?>
<div class='row'>
    <div class="col-sm-6 col-sm-offset-1">
        <?= $form->textFieldGroup($model, 'email', [
            'hint' => Yii::t('UserModule.user', 'Enter an email you have used during signup'),
            'labelOptions' => [
                'label' => false
            ]
        ]); ?>
    </div>
    <div class="col-sm-3 text-center">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context' => 'primary',
                'label' => Yii::t('UserModule.user', 'Recover password'),
            ]
        ); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

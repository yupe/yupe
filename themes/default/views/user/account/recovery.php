<?php
$this->title = [Yii::t('UserModule.user', 'Password recovery'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'Password recovery')];
?>
<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'          => 'registration-form',
        'type'        => 'vertical',
        'htmlOptions' => [
            'class' => 'well',
        ]
    ]
); ?>

<?= $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-xs-6">
        <?= $form->textFieldGroup(
            $model,
            'email',
            ['hint' => Yii::t('UserModule.user', 'Enter an email you have used during signup')]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Recover password'),
            ]
        ); ?>
    </div>
</div>

<?php $this->endWidget(); ?>

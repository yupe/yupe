<?php
$this->pageTitle = Yii::t('UserModule.user', 'Verify phone');
$this->breadcrumbs = [
    Yii::t('UserModule.user', 'User profile') => ['/user/account/profile'],
    Yii::t('UserModule.user', 'Verify phone')
];

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'profile-phone-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'htmlOptions'            => [
            'class' => 'well',
        ]
    ]
);
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup(
            $model,
            'token',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'autocomplete' => 'off',
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Verify phone'),
            ]
        ); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

<?php
$this->pageTitle = Yii::t('UserModule.user', 'Sign up');
$this->breadcrumbs = [Yii::t('UserModule.user', 'Sign up')];
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

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'nick_name'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->passwordFieldGroup($model, 'password'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?php echo $form->passwordFieldGroup($model, 'cPassword'); ?>
    </div>
</div>

<?php if ($module->showCaptcha && CCaptcha::checkRequirements()): { ?>
    <div class="row">
        <div class="col-xs-4">
            <?php echo $form->textFieldGroup(
                $model,
                'verifyCode',
                ['hint' => Yii::t('UserModule.user', 'Please enter the text from the image')]
            ); ?>
        </div>
        <div class="col-xs-4">
            <?php $this->widget(
                'CCaptcha',
                [
                    'showRefreshButton' => true,
                    'imageOptions'      => [
                        'width' => '150',
                    ],
                    'buttonOptions'     => [
                        'class' => 'btn btn-default',
                    ],
                    'buttonLabel'       => '<i class="glyphicon glyphicon-repeat"></i>',
                ]
            ); ?>
        </div>
    </div>
<?php } endif; ?>

<div class="row">
    <div class="col-xs-12">
        <?php
        $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Sign up'),
            ]
        ); ?>
    </div>
</div>

<hr/>

<?php if (Yii::app()->hasModule('social')): { ?>
    <div class="row">
        <div class="col-xs-12">
            <?php
            $this->widget(
                'vendor.nodge.yii-eauth.EAuthWidget',
                [
                    'action'             => '/social/login',
                    'predefinedServices' => ['google', 'facebook', 'vkontakte', 'twitter', 'github'],
                ]
            );
            ?>
        </div>
    </div>
<?php } endif; ?>

<?php $this->endWidget(); ?>
<!-- form -->

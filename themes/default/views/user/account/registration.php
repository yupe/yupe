<?php
$this->title = [Yii::t('UserModule.user', 'Sign up'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'Sign up')];
?>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<script type='text/javascript'>
    $(document).ready(function () {
        function str_rand(minlength) {
            var result = '';
            var words = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
            var max_position = words.length - 1;
            for (i = 0; i < minlength; ++i) {
                position = Math.floor(Math.random() * max_position);
                result = result + words.substring(position, position + 1);
            }
            return result;
        }

        $('#generate_password').click(function () {
            var pass = str_rand($(this).data('minlength'));
            $('#RegistrationForm_password').attr('type', 'text');
            $('#RegistrationForm_password').attr('value', pass);
            $('#RegistrationForm_cPassword').attr('value', pass);
        });
    })
</script>

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

<?php if (!$this->module->generateNickName) : ?>
    <div class='row'>
        <div class="col-xs-6">
            <?= $form->textFieldGroup($model, 'nick_name'); ?>
        </div>
    </div>
<?php endif; ?>

<div class='row'>
    <div class="col-xs-6">
        <?= $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?= $form->passwordFieldGroup($model, 'password'); ?>
    </div>
    <div class="col-xs-4" style="padding-top: 25px;">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'label' => Yii::t('UserModule.user', 'Generate password'),
                'htmlOptions' => [
                    'id' => 'generate_password',
                    'data-minlength' => $this->module->minPasswordLength
                ],
            ]
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-xs-6">
        <?= $form->passwordFieldGroup($model, 'cPassword'); ?>
    </div>
</div>

<?php if ($module->showCaptcha && CCaptcha::checkRequirements()): { ?>
    <div class="row">
        <div class="col-xs-4">
            <?= $form->textFieldGroup(
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
                    'imageOptions' => [
                        'width' => '150',
                    ],
                    'buttonOptions' => [
                        'class' => 'btn btn-default',
                    ],
                    'buttonLabel' => '<i class="glyphicon glyphicon-repeat"></i>',
                ]
            ); ?>
        </div>
    </div>
<?php } endif; ?>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context' => 'primary',
                'label' => Yii::t('UserModule.user', 'Sign up'),
            ]
        ); ?>
    </div>
</div>

<?php if (Yii::app()->hasModule('social')): { ?>
    <hr/>
    <div class="row">
        <div class="col-xs-12">
            <?php $this->widget(
                'vendor.nodge.yii-eauth.EAuthWidget',
                [
                    'action' => '/social/login',
                    'predefinedServices' => ['google', 'facebook', 'vkontakte', 'twitter', 'github'],
                ]
            ); ?>
        </div>
    </div>
<?php } endif; ?>

<?php $this->endWidget(); ?>
<!-- form -->

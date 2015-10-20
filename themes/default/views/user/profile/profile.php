<?php
$this->title = [Yii::t('UserModule.user', 'User profile'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('UserModule.user', 'User profile')];

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'profile-form',
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => [
            'class' => 'well',
            'enctype' => 'multipart/form-data',
        ]
    ]
);
?>

<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-3">
        <?php $this->widget('AvatarWidget', ['user' => $user, 'noCache' => true, 'imageHtmlOptions' => ['width' => 100, 'height' => 100]]); ?>
    </div>
    <div class="col-xs-9">
        <?= $form->checkBoxGroup(
            $model,
            'use_gravatar',
            [
                'hint' => Yii::t('UserModule.user', 'If you do not use Gravatar feel free to upload your own.')
            ]
        ); ?>

        <?= $form->fileFieldGroup(
            $model,
            'avatar',
            ['widgetOptions' => ['htmlOptions' => ['style' => 'background: inherit;']]]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?= $form->textFieldGroup(
            $user,
            'email',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'disabled' => true,
                        'class' => Yii::app()->getUser()->profile->getIsVerifyEmail() ? 'text-success' : ''
                    ],
                ],
                'append' => CHtml::link(Yii::t('UserModule.user', 'Change email'), ['/user/profile/email']),
            ]
        ); ?>
        <?php if (Yii::app()->getUser()->profile->getIsVerifyEmail()): { ?>
            <p class="email-status-confirmed text-success">
                <?= Yii::t('UserModule.user', 'E-mail was verified'); ?>
            </p>
        <?php } else: { ?>
            <p class="email-status-not-confirmed text-error">
                <?= Yii::t('UserModule.user', 'e-mail was not confirmed, please check you mail!'); ?>
            </p>
        <?php } endif ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?= $form->textFieldGroup($model, 'last_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?= $form->textFieldGroup($model, 'first_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?= $form->textFieldGroup($model, 'middle_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?= $form->dropDownListGroup(
            $model,
            'gender',
            [
                'widgetOptions' => [
                    'data' => User::model()->getGendersList(),
                    'htmlOptions' => [
                        'data-original-title' => $model->getAttributeLabel('gender'),
                        'data-content' => User::model()->getAttributeDescription('gender')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-5">
        <?= $form->datePickerGroup(
            $model,
            'birth_date',
            [
                'widgetOptions' => [
                    'options' => [
                        'format' => 'yyyy-mm-dd',
                    ],
                ],
                'prepend' => '<i class="glyphicon glyphicon-calendar"></i>'
            ]
        ); ?>
    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <?php echo $form->labelEx($model, 'phone', ['class' => 'control-label']); ?>
            <?php $this->widget(
                'CMaskedTextField',
                [
                    'model' => $model,
                    'attribute' => 'phone',
                    'mask' => $this->module->phoneMask,
                    'placeholder' => '*',
                    'htmlOptions' => [
                        'class' => 'form-control'
                    ]
                ]
            ); ?>
            <?php echo $form->error($model, 'phone'); ?>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <?= $form->textFieldGroup($model, 'location') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <?= $form->textFieldGroup($model, 'site') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?= $form->textAreaGroup(
            $model,
            'about',
            ['widgetOptions' => ['htmlOptions' => ['rows' => 7]]]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php if (is_array($this->module->profiles) && count($this->module->profiles)): { ?>
            <?php foreach ($this->module->profiles as $k => $p): { ?>
                <?php $this->renderPartial("//" . $k . "/" . $k . "_profile", ["model" => $p, "form" => $form]); ?>
            <?php } endforeach; ?>
        <?php } endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            [
                'buttonType' => 'submit',
                'context' => 'primary',
                'label' => Yii::t('UserModule.user', 'Save profile'),
            ]
        ); ?>
        <?= CHtml::link(Yii::t('UserModule.user', 'Change password'), ['/user/profile/password'], ['class' => 'btn btn-default']); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

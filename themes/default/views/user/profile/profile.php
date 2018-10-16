<?php
$this->pageTitle = Yii::t('UserModule.user', 'User profile');
$this->breadcrumbs = [Yii::t('UserModule.user', 'User profile')];

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'profile-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => [
            'class'   => 'well',
            'enctype' => 'multipart/form-data',
        ]
    ]
);
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-3">
        <?php $this->widget('AvatarWidget', ['user' => $user, 'noCache' => true, 'imageHtmlOptions' => ['width' => 100, 'height' => 100]]); ?>
    </div>
    <div class="col-xs-9">
        <?php echo $form->checkBoxGroup(
            $model,
            'use_gravatar',
            [
                'hint' => Yii::t('UserModule.user', 'If you do not use Gravatar feel free to upload your own.')
            ]
        ); ?>

        <?php echo $form->fileFieldGroup(
            $model,
            'avatar',
            ['widgetOptions' => ['htmlOptions' => ['style' => 'background: inherit;']]]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup(
            $user,
            'email',
            [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'disabled' => true,
                        'class'    => Yii::app()->user->profile->getIsVerifyEmail() ? 'text-success' : ''
                    ],
                ],
                'append'        => CHtml::link(Yii::t('UserModule.user', 'Change email'), ['/user/profile/email']),
            ]
        ); ?>
        <?php if (Yii::app()->user->profile->getIsVerifyEmail()): { ?>
            <p class="email-status-confirmed text-success">
                <?php echo Yii::t('UserModule.user', 'E-mail was verified'); ?>
            </p>
        <?php } else: { ?>
            <p class="email-status-not-confirmed text-error">
                <?php echo Yii::t('UserModule.user', 'e-mail was not confirmed, please check you mail!'); ?>
            </p>
        <?php } endif ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'last_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'first_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->textFieldGroup($model, 'middle_name') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6">
        <?php echo $form->dropDownListGroup(
            $model,
            'gender',
            [
                'widgetOptions' => [
                    'data'        => User::model()->getGendersList(),
                    'htmlOptions' => [
                        'data-original-title' => $model->getAttributeLabel('gender'),
                        'data-content'        => User::model()->getAttributeDescription('gender')
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <?php echo $form->datePickerGroup(
            $model,
            'birth_date',
            [
                'widgetOptions' => [
                    'options' => [
                        'format' => 'yyyy-mm-dd',
                    ],
                ],
                'prepend'       => '<i class="glyphicon glyphicon-calendar"></i>'
            ]
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <?php echo $form->textFieldGroup($model, 'location') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-8">
        <?php echo $form->textFieldGroup($model, 'site') ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php echo $form->textAreaGroup(
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
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Save profile'),
            ]
        ); ?>
        <?php echo CHtml::link(Yii::t('UserModule.user', 'Change password'), ['/user/profile/password'], ['class' => 'btn btn-default']); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

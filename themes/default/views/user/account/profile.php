<?php
$this->pageTitle = Yii::t('UserModule.user', 'User profile');
$this->breadcrumbs = array(Yii::t('UserModule.user', 'User profile'));

$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'profile-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array(
            'class'   => 'well',
            'enctype' => 'multipart/form-data',
        )
    )
);
?>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-xs-3">
        <?php $this->widget('AvatarWidget', array('user' => $user, 'noCache' => true)); ?>
    </div>
    <div class="col-xs-9">
        <?php echo $form->checkBoxGroup(
            $model,
            'use_gravatar',
            array(
                'hint' => Yii::t('UserModule.user', 'If you do not use Gravatar feel free to upload your own.')
            )
        ); ?>

        <?php echo $form->fileFieldGroup(
            $model,
            'avatar',
            array('widgetOptions' => array('htmlOptions' => array('style' => 'background: inherit;')))
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <?php echo $form->textFieldGroup(
            $user,
            'email',
            array(
                'widgetOptions' => array(
                    'htmlOptions' => array(
                        'disabled' => true,
                        'class'    => Yii::app()->user->profile->getIsVerifyEmail() ? 'text-success' : ''
                    ),
                ),
                'append'        => CHtml::link(Yii::t('UserModule.user', 'Change email'), array('/user/account/profileEmail')),
            )
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
            array(
                'widgetOptions' => array(
                    'data'        => User::model()->getGendersList(),
                    'htmlOptions' => array(
                        'data-original-title' => $model->getAttributeLabel('gender'),
                        'data-content'        => User::model()->getAttributeDescription('gender')
                    ),
                ),
            )
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-3">
        <?php echo $form->datePickerGroup(
            $model,
            'birth_date',
            array(
                'widgetOptions' => array(
                    'options' => array(
                        'format' => 'yyyy-mm-dd',
                    ),
                ),
                'prepend'       => '<i class="glyphicon glyphicon-calendar"></i>'
            )
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
            array('widgetOptions' => array('htmlOptions' => array('rows' => 7)))
        ); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php if (is_array($this->module->profiles) && count($this->module->profiles)): { ?>
            <?php foreach ($this->module->profiles as $k => $p): { ?>
                <?php $this->renderPartial("//" . $k . "/" . $k . "_profile", array("model" => $p, "form" => $form)); ?>
            <?php } endforeach; ?>
        <?php } endif; ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'buttonType' => 'submit',
                'context'    => 'primary',
                'label'      => Yii::t('UserModule.user', 'Save profile'),
            )
        ); ?>
        <?php echo CHtml::link(Yii::t('UserModule.user', 'Change password'), array('/user/account/profilePassword'), array('class' => 'btn btn-default')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>

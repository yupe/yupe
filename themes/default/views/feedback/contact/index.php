<?php
$this->pageTitle = Yii::t('FeedbackModule.feedback','Contacts');
$this->breadcrumbs = array(Yii::t('FeedbackModule.feedback','Contacts'));
Yii::import('application.modules.feedback.FeedbackModule');
Yii::import('application.modules.install.InstallModule');
?>

<h1><?php echo Yii::t('FeedbackModule.feedback','Contacts'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<div class="alert alert-notice">

    <p> <?php echo Yii::t('FeedbackModule.feedback','If you have any questions, proposals or want to report an error'); ?></p>

    <p> <?php echo Yii::t('FeedbackModule.feedback','If you interesting with quality project which simple in support'); ?></p>

    <p><b><?php echo Yii::t('FeedbackModule.feedback','Immediately <a href="http://yupe.ru/contacts?from=contact" target="_blank">write to us</a> about it!'); ?></b></p>
    <p> <?php echo Yii::t('FeedbackModule.feedback','We try to answer as fast as we can!'); ?></p>

    <p><b><?php echo Yii::t('FeedbackModule.feedback','Thanks for attention!'); ?></b></p>

</div>

<div class="form">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id' => 'feedback-form',
            'type' => 'vertical',
            'inlineErrors' => true,
            'htmlOptions' => array(
                'class' => 'well',
            )
        )
    ); ?>

    <p class="note"><?php echo Yii::t('FeedbackModule.feedback','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('FeedbackModule.feedback','are required.'); ?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->type): ?>
        <div class='row-fluid control-group <?php echo $model->hasErrors('type') ? 'error' : ''; ?>'>
            <?php echo $form->dropDownListRow($model, 'type', $module->types, array('class' => 'span6', 'required' => true)); ?>
        </div>
    <?php endif; ?>

    <div class='row-fluid control-group <?php echo $model->hasErrors('name') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'name', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('email') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'email', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('theme') ? 'error' : ''; ?>'>
        <?php echo $form->textFieldRow($model, 'theme', array('class' => 'span6', 'required' => true)); ?>
    </div>

    <div class='row-fluid control-group <?php echo $model->hasErrors('text') ? 'error' : ''; ?>'>
       <?php echo $form->textAreaRow($model,'text', array('class' => 'span8','rows' => 10, 'required' => true));?>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
        <?php if (CCaptcha::checkRequirements()): ?>

                <?php echo $form->labelEx($model, 'verifyCode'); ?>

                <?php $this->widget(
                    'CCaptcha',
                    array(
                        'showRefreshButton' => true,
                        'imageOptions' => array(
                            'width' => '150',
                        ),
                        'buttonOptions' => array(
                            'class' => 'btn',
                        ),
                        'buttonLabel' => '<i class="icon-repeat"></i>',
                    )
                ); ?>

                <div class='row-fluid control-group <?php echo $model->hasErrors('verifyCode') ? 'error' : ''; ?>'>
                    <?php echo $form->textFieldRow($model, 'verifyCode', array('placeholder' => Yii::t('FeedbackModule.feedback', 'Insert symbols you see on image'),'class' => 'span6', 'required' => true)); ?>
                </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'type' => 'primary',
            'label' => Yii::t('FeedbackModule.feedback', 'Send message'),
        )
    ); ?>


    <?php $this->endWidget(); ?>
</div>


<div class="alert alert-success">

    <p><?php echo Yii::t('InstallModule.install', 'Interesting links:'); ?></p>

    <?php echo CHtml::link(Yii::t('InstallModule.install', 'Official docs'), 'http://yupe.ru/docs/index.html?from=contact'); ?>  - <?php echo Yii::t('InstallModule.install', 'We working with it'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('InstallModule.install', 'Support Yupe forum'), 'http://yupe.ru/talk/'); ?>  - <?php echo Yii::t('InstallModule.install', 'All discussions here'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('InstallModule.install', 'Official Yupe twitter'), 'https://twitter.com/#!/YupeCms'); ?>  - <?php echo Yii::t('InstallModule.install', 'Follow us'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('InstallModule.install', 'Sources on GitHub'), 'http://github.com/yupe/yupe/'); ?> - <?php echo Yii::t('InstallModule.install', 'Send pull request'); ?>

    <br/><br/>

    <?php echo CHtml::link(Yii::t('InstallModule.install', 'General sponsor'), 'http://amylabs.ru?from=yupe-contact'); ?> - <?php echo Yii::t('InstallModule.install', 'Just good guys'); ?>

</div>
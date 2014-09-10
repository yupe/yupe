<?php
$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Contacts');
$this->breadcrumbs = array(Yii::t('FeedbackModule.feedback', 'Contacts'));
Yii::import('application.modules.feedback.FeedbackModule');
Yii::import('application.modules.install.InstallModule');
?>

<h1><?php echo Yii::t('FeedbackModule.feedback', 'Contacts'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<div class="alert alert-warning">
    <p>
        <?php echo Yii::t(
            'FeedbackModule.feedback',
            'If you have any questions, proposals or want to report an error'
        ); ?>
    </p>

    <p>
        <?php echo Yii::t(
            'FeedbackModule.feedback',
            'If you interesting with quality project which simple in support'
        ); ?>
    </p>

    <p>
        <b><?php echo Yii::t(
                'FeedbackModule.feedback',
                'Immediately <a href="http://yupe.ru/contacts?from=contact" target="_blank">write to us</a> about it!'
            ); ?></b>
    </p>

    <p>
        <?php echo Yii::t('FeedbackModule.feedback', 'We try to answer as fast as we can!'); ?>
    </p>

    <p>
        <b><?php echo Yii::t('FeedbackModule.feedback', 'Thanks for attention!'); ?></b>
    </p>
</div>

<div class="form">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        array(
            'id'          => 'feedback-form',
            'type'        => 'vertical',
            'htmlOptions' => array(
                'class' => 'well',
            )
        )
    ); ?>

    <p class="alert alert-info">
        <?php echo Yii::t('FeedbackModule.feedback', 'Fields with'); ?> <span
            class="required">*</span> <?php echo Yii::t('FeedbackModule.feedback', 'are required.'); ?>
    </p>

    <?php echo $form->errorSummary($model); ?>

    <?php if ($model->type): ?>
        <div class='row'>
            <div class="col-sm-6">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'type',
                    array(
                        'widgetOptions' => array(
                            'data' => $module->getTypes(),
                        ),
                    )
                ); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class='row'>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model, 'email'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-6">
            <?php echo $form->textFieldGroup($model, 'theme'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-7">
            <?php echo $form->textAreaGroup(
                $model,
                'text',
                array('widgetOptions' => array('htmlOptions' => array('rows' => 10)))
            ); ?>
        </div>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->user->isAuthenticated()): ?>
        <?php if (CCaptcha::checkRequirements()): ?>
            <?php $this->widget(
                'CCaptcha',
                array(
                    'showRefreshButton' => true,
                    'imageOptions'      => array(
                        'width' => '150',
                    ),
                    'buttonOptions'     => array(
                        'class' => 'btn btn-info',
                    ),
                    'buttonLabel'       => '<i class="glyphicon glyphicon-repeat"></i>',
                )
            ); ?>
            <div class='row'>
                <div class="col-sm-6">
                    <?php echo $form->textFieldGroup(
                        $model,
                        'verifyCode',
                        array(
                            'widgetOptions' => array(
                                'htmlOptions' => array(
                                    'placeholder' => Yii::t(
                                            'FeedbackModule.feedback',
                                            'Insert symbols you see on image'
                                        )
                                ),
                            ),
                        )
                    ); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('FeedbackModule.feedback', 'Send message'),
        )
    ); ?>

    <?php $this->endWidget(); ?>
</div>

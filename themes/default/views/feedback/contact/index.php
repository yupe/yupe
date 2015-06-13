<?php
$this->title = [Yii::t('FeedbackModule.feedback', 'Contacts'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('FeedbackModule.feedback', 'Contacts')];
Yii::import('application.modules.feedback.FeedbackModule');
Yii::import('application.modules.install.InstallModule');
?>

<h1><?= Yii::t('FeedbackModule.feedback', 'Contacts'); ?></h1>

<?php $this->widget('yupe\widgets\YFlashMessages'); ?>

<div class="alert alert-warning">
    <p>
        <?= Yii::t(
            'FeedbackModule.feedback',
            'If you have any questions, proposals or want to report an error'
        ); ?>
    </p>

    <p>
        <?= Yii::t(
            'FeedbackModule.feedback',
            'If you interesting with quality project which simple in support'
        ); ?>
    </p>

    <p>
        <b><?= Yii::t(
                'FeedbackModule.feedback',
                'Immediately <a href="http://yupe.ru/contacts?from=contact" target="_blank">write to us</a> about it!'
            ); ?></b>
    </p>

    <p>
        <?= Yii::t('FeedbackModule.feedback', 'We try to answer as fast as we can!'); ?>
    </p>

    <p>
        <b><?= Yii::t('FeedbackModule.feedback', 'Thanks for attention!'); ?></b>
    </p>
</div>

<div class="form">
    <?php $form = $this->beginWidget(
        'bootstrap.widgets.TbActiveForm',
        [
            'id'          => 'feedback-form',
            'type'        => 'vertical',
            'htmlOptions' => [
                'class' => 'well',
            ]
        ]
    ); ?>

    <p class="alert alert-info">
        <?= Yii::t('FeedbackModule.feedback', 'Fields with'); ?> <span
            class="required">*</span> <?= Yii::t('FeedbackModule.feedback', 'are required.'); ?>
    </p>

    <?= $form->errorSummary($model); ?>

    <?php if ($model->type): ?>
        <div class='row'>
            <div class="col-sm-6">
                <?= $form->dropDownListGroup(
                    $model,
                    'type',
                    [
                        'widgetOptions' => [
                            'data' => $module->getTypes(),
                        ],
                    ]
                ); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class='row'>
        <div class="col-sm-6">
            <?= $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-6">
            <?= $form->textFieldGroup($model, 'email'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-6">
            <?= $form->textFieldGroup($model, 'theme'); ?>
        </div>
    </div>

    <div class='row'>
        <div class="col-sm-7">
            <?= $form->textAreaGroup(
                $model,
                'text',
                ['widgetOptions' => ['htmlOptions' => ['rows' => 10]]]
            ); ?>
        </div>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->getUser()->isAuthenticated()): ?>
        <?php if (CCaptcha::checkRequirements()): ?>
            <?php $this->widget(
                'CCaptcha',
                [
                    'showRefreshButton' => true,
                    'imageOptions'      => [
                        'width' => '150',
                    ],
                    'buttonOptions'     => [
                        'class' => 'btn btn-info',
                    ],
                    'buttonLabel'       => '<i class="glyphicon glyphicon-repeat"></i>',
                ]
            ); ?>
            <div class='row'>
                <div class="col-sm-6">
                    <?= $form->textFieldGroup(
                        $model,
                        'verifyCode',
                        [
                            'widgetOptions' => [
                                'htmlOptions' => [
                                    'placeholder' => Yii::t(
                                        'FeedbackModule.feedback',
                                        'Insert symbols you see on image'
                                    )
                                ],
                            ],
                        ]
                    ); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => Yii::t('FeedbackModule.feedback', 'Send message'),
        ]
    ); ?>

    <?php $this->endWidget(); ?>
</div>

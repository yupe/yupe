<?php
/**
 * @var CActiveForm $form
 */
$this->title = [Yii::t('FeedbackModule.feedback', 'Contacts'), Yii::app()->getModule('yupe')->siteName];
$this->breadcrumbs = [Yii::t('FeedbackModule.feedback', 'Contacts')];
Yii::import('application.modules.feedback.FeedbackModule');
Yii::import('application.modules.install.InstallModule');
?>
<div class="main__title grid">
    <h1 class="h2"><?= Yii::t('FeedbackModule.feedback', 'Contacts'); ?></h1>
</div>
<div class="main__catalog grid">
    <div class="grid-module-6">
        <?php $this->widget('yupe\widgets\YFlashMessages'); ?>
    </div>
    <div class="alert alert-warning grid-module-6 fast-order__inputs">
        <p>
            <?= Yii::t('FeedbackModule.feedback',
                'If you have any questions, proposals or want to report an error'
            ); ?>
        </p>

        <p>
            <?= Yii::t('FeedbackModule.feedback',
                'If you interesting with quality project which simple in support'
            ); ?>
        </p>

        <p>
            <b>
                <?= Yii::t('FeedbackModule.feedback',
                    'Immediately <a href="http://yupe.ru/contacts?from=contact" target="_blank">write to us</a> about it!'
                ); ?>
            </b>
        </p>

        <p>
            <?= Yii::t('FeedbackModule.feedback', 'We try to answer as fast as we can!'); ?>
        </p>

        <p>
            <b><?= Yii::t('FeedbackModule.feedback', 'Thanks for attention!'); ?></b>
        </p>
    </div>

    <div class="grid-module-6 ">
        <?php $form = $this->beginWidget('CActiveForm', [
            'id' => 'feedback-form',
        ]); ?>

        <p class="alert alert-info fast-order__inputs">
            <?= Yii::t('FeedbackModule.feedback', 'Fields with'); ?> <span
                class="required">*</span> <?= Yii::t('FeedbackModule.feedback', 'are required.'); ?>
        </p>

        <?= $form->errorSummary($model); ?>

        <?php if ($model->type): ?>
            <div class='row'>
                <div class="col-sm-6">
                    <?= $form->dropDownList($model, 'type', [
                        'data' => $module->getTypes(),
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'name'); ?>
            <?= $form->textField($model, 'name', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'name') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'email'); ?>
            <?= $form->textField($model, 'email', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'email') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'theme'); ?>
            <?= $form->textField($model, 'theme', ['class' => 'input input_big']); ?>
            <?= $form->error($model, 'theme') ?>
        </div>

        <div class="fast-order__inputs">
            <?= $form->labelEx($model, 'text'); ?>
            <?= $form->textArea($model, 'text', ['class' => 'input input_big', 'rows' => 10]); ?>
            <?= $form->error($model, 'text') ?>
        </div>

        <?php if ($module->showCaptcha && !Yii::app()->getUser()->isAuthenticated()): ?>
            <?php if (CCaptcha::checkRequirements()): ?>
                <div class="fast-order__inputs">
                    <div class="column grid-module-3">
                        <?= $form->textField($model, 'verifyCode', [
                            'class' => 'input input_big',
                            'placeholder' => Yii::t('FeedbackModule.feedback', 'Insert symbols you see on image')
                        ]); ?>
                    </div>
                    <div class="column grid-module-3 pull-right">
                        <?php $this->widget(
                            'CCaptcha',
                            [
                                'showRefreshButton' => true,
                                'imageOptions' => [
                                    'width' => '150',
                                ],
                                'buttonOptions' => [
                                    'class' => 'btn btn_big btn_white pull-right',
                                ],
                                'buttonLabel' => '<i class="fa fa-fw fa-repeat"></i>',
                            ]
                        ); ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <div class="fast-order__inputs">
            <div class="grid-module-3">
                <?= CHtml::submitButton(Yii::t('FeedbackModule.feedback', 'Send message'), [
                    'id' => 'login-btn',
                    'class' => 'btn btn_big btn_wide btn_primary'
                ]) ?>
            </div>
        </div>

        <?php $this->endWidget(); ?>
    </div>
</div>
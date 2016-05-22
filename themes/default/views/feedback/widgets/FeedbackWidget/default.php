<?php
/**
 * @var FeedbackForm $model
 * @var TbActiveForm $form
 * @var FeedbackModule $module
 */
?>
<div class="row">
    <?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', [
        'id' => 'feedback-widget-form',
        'type' => 'vertical',
        'action' => ['/feedback/contact/index'],
        'enableClientValidation' => true,
        'clientOptions'=>array(
            'validateOnSubmit'=>true,
            'afterValidate'=>'js:feedbackWidgetFormSend'
        )
    ]); ?>

    <?= $form->errorSummary($model); ?>

    <?php if ($model->type): ?>
        <div class="row">
            <div class="col-xs-12">
                <?= $form->dropDownListGroup($model, 'type', [
                    'widgetOptions' => [
                        'data' => $module->getTypes(),
                    ],
                ]); ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->textFieldGroup($model, 'name'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->textFieldGroup($model, 'email'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->textFieldGroup($model, 'theme'); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= $form->textAreaGroup($model, 'text', [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'rows' => 5
                    ]
                ]
            ]); ?>
        </div>
    </div>

    <?php if ($module->showCaptcha && !Yii::app()->getUser()->isAuthenticated()): ?>
        <?php if (CCaptcha::checkRequirements()): ?>
            <?php $this->widget('CCaptcha', [
                'showRefreshButton' => true,
                'imageOptions' => [
                    'width' => '150',
                ],
                'buttonOptions' => [
                    'class' => 'btn btn-info',
                ],
                'buttonLabel' => '<i class="glyphicon glyphicon-repeat"></i>',
            ]); ?>
            <div class="row">
                <div class="col-xs-12">
                    <?= $form->textFieldGroup($model, 'verifyCode', [
                        'widgetOptions' => [
                            'htmlOptions' => [
                                'placeholder' => Yii::t(
                                    'FeedbackModule.feedback',
                                    'Insert symbols you see on image'
                                )
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php
    $this->widget('bootstrap.widgets.TbButton', [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('FeedbackModule.feedback', 'Send message'),
    ]); ?>

    <?php $this->endWidget(); ?>
</div>
<script type="text/javascript">
    function feedbackWidgetFormSend(form, data, hasError) {
        if (hasError) {
            return false;
        }

        $.ajax({
            method: 'POST',
            url: form.attr('action'),
            data: form.serialize(),
            success: function(data){
                var type = data.result ? 'success' : 'danger';
                $('#notifications').notify({message:{text:data.data},type:type}).show();

                if (data.result) {
                    form.trigger('reset');
                }
            }
        });

        return false;
    }
</script>
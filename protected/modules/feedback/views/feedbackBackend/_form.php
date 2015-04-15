<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id'                     => 'feedback-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'action'                 => $model->isNewRecord ? ['create'] : ['update', 'id' => $model->id],
        'htmlOptions'            => ['class' => 'well'],
    ]
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('FeedbackModule.feedback', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('FeedbackModule.feedback', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-2">
        <?php echo $form->dropDownListGroup(
            $model,
            'type',
            [
                'widgetOptions' => [
                    'data'        => Yii::app()->getModule('feedback')->getTypes(),
                    'htmlOptions' => [
                        'empty' => Yii::t('FeedbackModule.feedback', '--choose--'),
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-3">
        <?php echo $form->dropDownListGroup(
            $model,
            'category_id',
            [
                'widgetOptions' => [
                    'data'        => Category::model()->getFormattedList(
                            (int)Yii::app()->getModule('feedback')->mainCategory
                        ),
                    'htmlOptions' => [
                        'empty' => Yii::t('FeedbackModule.feedback', '--choose--'),
                    ],
                ],
            ]
        ); ?>
    </div>
    <div class="col-sm-2">
        <?php echo $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data'        => $model->getStatusList(),
                    'htmlOptions' => [
                        'empty' => Yii::t('FeedbackModule.feedback', '--choose--'),
                    ],
                ],
            ]
        ); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'email'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'phone'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->textFieldGroup($model, 'theme'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'id'        => substr(md5(microtime()), 0, 7),
                'model'     => $model,
                'attribute' => 'text',
            ]
        ); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($model, 'answer'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'id'        => substr(md5(microtime()), 0, 7),
                'model'     => $model,
                'attribute' => 'answer',
            ]
        ); ?>
        <?php echo $form->error($model, 'answer'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <?php echo $form->checkBoxGroup($model, 'is_faq'); ?>
    </div>
</div>
<?php if ($model->status == FeedBack::STATUS_ANSWER_SENDED && isset($model->answer_user)): ?>
    <div class="row">
        <div class="col-sm-7 form-group">
            <label><?php echo Yii::t('FeedbackModule.feedback', 'Ответил'); ?> <?php echo CHtml::link(
                    $model->getAnsweredUser()->nick_name,
                    ['/user/userBackend/view', 'id' => $model->answer_user]
                ); ?> (<?php echo $model->answer_time; ?>)</label>
            <?php echo $model->answer; ?>
        </div>
    </div>
<?php endif; ?>

<div class='controls'>
    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType' => 'submit',
            'context'    => 'primary',
            'label'      => $model->isNewRecord ? Yii::t(
                    'FeedbackModule.feedback',
                    'Create message and continue'
                ) : Yii::t('FeedbackModule.feedback', 'Save message and continue'),
        ]
    ); ?>

    <?php $this->widget(
        'bootstrap.widgets.TbButton',
        [
            'buttonType'  => 'submit',
            'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
            'label'       => $model->isNewRecord ? Yii::t(
                    'FeedbackModule.feedback',
                    'Create message and close'
                ) : Yii::t('FeedbackModule.feedback', 'Save message and close'),
        ]
    ); ?>
</div>

<?php $this->endWidget(); ?>

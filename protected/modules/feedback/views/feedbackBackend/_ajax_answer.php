<?php $this->widget(
    'bootstrap.widgets.TbDetailView', array(
        'data'       => $model,
        'attributes' => array(
            'creation_date',
            'name',
            'email',
            'theme',
            array(
                'name' => 'text',
                'type' => 'raw',
            ),
        ),
    )
); ?>

<?php $form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm', array(
        'action'                 => array('/feedback/feedbackBackend/answer', 'id' => $model->id),
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well ajax-form'),
        'inlineErrors'           => true,
    )
); ?>

    <div class="row-fluid control-group">
        <?php echo $form->textAreaRow(
            $answerForm,  'answer',  array(
                'imageUpload' => $this->createUrl('/yupe/backend/AjaxImageUpload'),
                'class'       => 'span12 answer-text',
            )
        ); ?>
    </div>
    <div class="row-fluid control-group">
        <div class="span12">
            <?php echo $form->checkBoxRow($answerForm, 'is_faq'); ?>
        </div>
    </div>

    <?php $this->widget(
        'bootstrap.widgets.TbButton', array(
            'buttonType'  => 'submit',
            'type'        => 'primary',
            'label'       => Yii::t('FeedbackModule.feedback', 'Send reply for message'),
            'htmlOptions' => array(
                'class'      => 'btn-block'
            )
        )
    ); ?>

<?php $this->endWidget(); ?>
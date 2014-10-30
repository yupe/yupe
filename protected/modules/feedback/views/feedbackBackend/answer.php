<?php

$this->breadcrumbs = array(
    Yii::t('FeedbackModule.feedback', 'Messages ') => array('/feedback/feedbackBackend/index'),
    $model->theme => array('/feedback/feedbackBackend/view', 'id' => $model->id),
    Yii::t('FeedbackModule.feedback', 'Reply'),
);

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - answer');

$this->menu = array(
    array(
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('FeedbackModule.feedback', 'Messages management'),
        'url' => array('/feedback/feedbackBackend/index')
    ),
    array(
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('FeedbackModule.feedback', 'Create message '),
        'url' => array('/feedback/feedbackBackend/create')
    ),
    array(
        'label' => Yii::t('FeedbackModule.feedback', 'Reference value') . ' «' . mb_substr(
                $model->theme,
                0,
                32
            ) . '»'
    ),
    array(
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('FeedbackModule.feedback', 'Edit message '),
        'url' => array(
            '/feedback/feedbackBackend/update',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('FeedbackModule.feedback', 'View message'),
        'url' => array(
            '/feedback/feedbackBackend/view',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-envelope',
        'label' => Yii::t('FeedbackModule.feedback', 'Reply for message'),
        'url' => array(
            '/feedback/feedbackBackend/answer',
            'id' => $model->id
        )
    ),
    array(
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('FeedbackModule.feedback', 'Remove message '),
        'url' => '#',
        'linkOptions' => array(
            'submit' => array('/feedback/feedbackBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('FeedbackModule.feedback', 'Do you really want to remove message?'),
        )
    ),
);
?>

<script type='text/javascript'>
    $(document).ready(function () {
        var email = '<?php echo $model->email; ?>';
        $('input:submit').click(function () {
            if (window.confirm('<?php echo Yii::t('FeedbackModule.feedback', 'Reply will be send on '); ?>' + email + '<?php echo Yii::t('FeedbackModule.feedback', ' продолжить ?'); ?>'))
                return true;
            return false;
        });
    });
</script>

<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Reply on message'); ?><br/>
        <small>&laquo;<?php echo $model->theme; ?>&raquo;</small>
    </h1>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    array(
        'data' => $model,
        'attributes' => array(
            'creation_date',
            'name',
            'email',
            'phone',
            'theme',
            array(
                'name' => 'text',
                'type' => 'raw',
            ),
            array(
                'name' => 'type',
                'value' => $model->getType(),
            ),
            array(
                'name' => 'status',
                'value' => $model->getStatus(),
            ),
        ),
    )
); ?>

<br/><br/>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id' => 'feed-back-form-answer',
        'action' => array('/feedback/feedbackBackend/answer', 'id' => $model->id),
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => array('class' => 'well'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t('FeedbackModule.feedback', 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t('FeedbackModule.feedback', 'are required.'); ?>
</div>

<?php echo $form->errorSummary($answerForm); ?>

<div class="row">
    <div class="col-sm-12 form-group">
        <?php echo $form->labelEx($answerForm, 'answer'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            array(
                'model' => $answerForm,
                'attribute' => 'answer',
                'options' => array(
                    'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxImageUpload/',
                ),
                'htmlOptions' => array('rows' => 20, 'cols' => 6),
            )
        ); ?>
        <?php echo $form->error($answerForm, 'answer'); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <?php echo $form->checkBoxGroup($answerForm, 'is_faq'); ?>
    </div>
</div>

<?php $this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('FeedbackModule.feedback', 'Send reply for message'),
    )
); ?>

<?php $this->endWidget(); ?>

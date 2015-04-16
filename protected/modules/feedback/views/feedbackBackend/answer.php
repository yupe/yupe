<?php

$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'Messages ') => ['/feedback/feedbackBackend/index'],
    $model->theme => ['/feedback/feedbackBackend/view', 'id' => $model->id],
    Yii::t('FeedbackModule.feedback', 'Reply'),
];

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - answer');

$this->menu = [
    [
        'icon' => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('FeedbackModule.feedback', 'Messages management'),
        'url' => ['/feedback/feedbackBackend/index']
    ],
    [
        'icon' => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('FeedbackModule.feedback', 'Create message '),
        'url' => ['/feedback/feedbackBackend/create']
    ],
    [
        'label' => Yii::t('FeedbackModule.feedback', 'Reference value') . ' «' . mb_substr(
                $model->theme,
                0,
                32
            ) . '»'
    ],
    [
        'icon' => 'fa fa-fw fa-pencil',
        'label' => Yii::t('FeedbackModule.feedback', 'Edit message '),
        'url' => [
            '/feedback/feedbackBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-eye',
        'label' => Yii::t('FeedbackModule.feedback', 'View message'),
        'url' => [
            '/feedback/feedbackBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-envelope',
        'label' => Yii::t('FeedbackModule.feedback', 'Reply for message'),
        'url' => [
            '/feedback/feedbackBackend/answer',
            'id' => $model->id
        ]
    ],
    [
        'icon' => 'fa fa-fw fa-trash-o',
        'label' => Yii::t('FeedbackModule.feedback', 'Remove message '),
        'url' => '#',
        'linkOptions' => [
            'submit' => ['/feedback/feedbackBackend/delete', 'id' => $model->id],
            'params' => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('FeedbackModule.feedback', 'Do you really want to remove message?'),
        ]
    ],
];
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
    [
        'data' => $model,
        'attributes' => [
            'create_time',
            'name',
            'email',
            'phone',
            'theme',
            [
                'name' => 'text',
                'type' => 'raw',
            ],
            [
                'name' => 'type',
                'value' => $model->getType(),
            ],
            [
                'name' => 'status',
                'value' => $model->getStatus(),
            ],
        ],
    ]
); ?>

<br/><br/>

<?php
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    [
        'id' => 'feed-back-form-answer',
        'action' => ['/feedback/feedbackBackend/answer', 'id' => $model->id],
        'enableAjaxValidation' => false,
        'enableClientValidation' => true,
        'type' => 'vertical',
        'htmlOptions' => ['class' => 'well'],
    ]
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
            [
                'model' => $answerForm,
                'attribute' => 'answer',
                'options' => [
                    'imageUpload' => Yii::app()->baseUrl . '/index.php/yupe/backend/AjaxImageUpload/',
                ],
                'htmlOptions' => ['rows' => 20, 'cols' => 6],
            ]
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
    [
        'buttonType' => 'submit',
        'context' => 'primary',
        'label' => Yii::t('FeedbackModule.feedback', 'Send reply for message'),
    ]
); ?>

<?php $this->endWidget(); ?>

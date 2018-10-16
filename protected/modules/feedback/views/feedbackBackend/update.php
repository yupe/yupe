<?php
$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'Messages ') => ['/feedback/feedbackBackend/index'],
    $model->theme                                  => ['/feedback/feedbackBackend/view', 'id' => $model->id],
    Yii::t('FeedbackModule.feedback', 'Edit'),
];

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - edit');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('FeedbackModule.feedback', 'Messages management'),
        'url'   => ['/feedback/feedbackBackend/index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('FeedbackModule.feedback', 'Create message '),
        'url'   => ['/feedback/feedbackBackend/create']
    ],
    [
        'label' => Yii::t('FeedbackModule.feedback', 'Reference value') . ' «' . mb_substr(
                $model->theme,
                0,
                32
            ) . '»'
    ],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t('FeedbackModule.feedback', 'Edit message '),
        'url'   => [
            '/feedback/feedbackBackend/update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t('FeedbackModule.feedback', 'View message'),
        'url'   => [
            '/feedback/feedbackBackend/view',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-envelope',
        'label' => Yii::t('FeedbackModule.feedback', 'Reply for message'),
        'url'   => [
            '/feedback/feedbackBackend/answer',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t('FeedbackModule.feedback', 'Remove message '),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => ['/feedback/feedbackBackend/delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t('FeedbackModule.feedback', 'Do you really want to remove message?'),
        ]
    ],
];
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Change message '); ?><br/>
        <small>&laquo;<?php echo $model->theme; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>

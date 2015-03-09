<?php
$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'Messages ') => ['/feedback/feedbackBackend/index'],
    Yii::t('FeedbackModule.feedback', 'Creating'),
];

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - add');

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
];
?>
<h1>
    <?php echo Yii::t('FeedbackModule.feedback', 'Messages '); ?>
    <small><?php echo Yii::t('FeedbackModule.feedback', 'adding'); ?></small>
</h1>

<?php echo $this->renderPartial('_form', ['model' => $model]); ?>

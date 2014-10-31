<?php
$this->breadcrumbs = array(
    Yii::t('FeedbackModule.feedback', 'Messages ') => array('/feedback/feedbackBackend/index'),
    Yii::t('FeedbackModule.feedback', 'adding'),
);

$this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - add');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t('FeedbackModule.feedback', 'Messages management'),
        'url'   => array('/feedback/feedbackBackend/index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t('FeedbackModule.feedback', 'Create message '),
        'url'   => array('/feedback/feedbackBackend/create')
    ),
);
?>
<h1>
    <?php echo Yii::t('FeedbackModule.feedback', 'Messages '); ?>
    <small><?php echo Yii::t('FeedbackModule.feedback', 'adding'); ?></small>
</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

<?php
    $this->breadcrumbs = array(      
        Yii::t('FeedbackModule.feedback', 'Messages ') => array('/feedback/feedbackBackend/index'),
        $model->theme => array('/feedback/feedbackBackend/view', 'id' => $model->id),
        Yii::t('FeedbackModule.feedback', 'Edit'),
    );

    $this->pageTitle = Yii::t('FeedbackModule.feedback', 'Messages - edit');

    $this->menu = array(
        array('icon' => 'list-alt', 'label' => Yii::t('FeedbackModule.feedback', 'Messages management'), 'url' => array('/feedback/feedbackBackend/index')),
        array('icon' => 'plus-sign', 'label' => Yii::t('FeedbackModule.feedback', 'Create message '), 'url' => array('/feedback/feedbackBackend/create')),
        array('label' => Yii::t('FeedbackModule.feedback', 'Reference value') . ' «' . mb_substr($model->theme, 0, 32) . '»'),
        array('icon' => 'pencil', 'label' => Yii::t('FeedbackModule.feedback', 'Edit message '), 'url' => array(
            '/feedback/feedbackBackend/update',
            'id' => $model->id
        )),
        array('icon' => 'eye-open', 'label' => Yii::t('FeedbackModule.feedback', 'View message'), 'url' => array(
            '/feedback/feedbackBackend/view',
            'id' => $model->id
        )),
        array('icon' => 'envelope', 'label' => Yii::t('FeedbackModule.feedback', 'Reply for message'), 'url' => array(
            '/feedback/feedbackBackend/answer',
            'id' => $model->id
        )),
        array('icon' => 'trash', 'label' => Yii::t('FeedbackModule.feedback', 'Remove message '), 'url' => '#', 'linkOptions' => array(
            'submit'  => array('/feedback/feedbackBackend/delete', 'id' => $model->id),
            'params' => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t('FeedbackModule.feedback', 'Do you really want to remove message?'),
        )),
    );
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t('FeedbackModule.feedback', 'Change message '); ?><br />
        <small>&laquo;<?php echo $model->theme; ?>&raquo;</small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>

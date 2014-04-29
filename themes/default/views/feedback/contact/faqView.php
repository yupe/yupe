<?php $this->pageTitle = $model->theme; ?>
<?php $this->keywords = implode(',', explode(' ', $model->theme)); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('FeedbackModule.feedback', 'FAQ') => array('/feedback/contact/faq/'),
    $model->theme,
);
?>

<h1>
    <?php echo $model->theme; ?> #<?php echo $model->id; ?>
    <?php
    $this->widget(
        'bootstrap.widgets.TbButton',
        array(
            'htmlOptions' => array(
                'class' => 'btn btn-info'
            ),
            'buttonType' => 'link',
            'label' => Yii::t('FeedbackModule.feedback', 'Add question ?'),
            'url' => Yii::app()->createUrl('/feedback/contact/index/'),
        )
    ); ?>
</h1>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
        'creation_date',
        'name',
        'theme',
        array(
            'name' => 'text',
            'type' => 'raw',
            'value' => $model->text,
        ),

        array(
            'name' => 'type',
            'value' => $model->getType()
        ),
        array(
            'name' => 'answer_user',
            'value' => $model->getAnsweredUser()->FullName
        ),
        'answer_date',
        array(
            'name' => 'answer',
            'type' => 'raw'
        ),
    ),
)); ?>

<br/><br/>

<?php $this->widget('application.modules.comment.widgets.CommentsListWidget', array('label' => Yii::t('FeedbackModule.feedback', 'Opinions'), 'model' => $model, 'modelId' => $model->id)); ?>

<br/>

<h3><?php echo Yii::t('FeedbackModule.feedback', 'Do you have your own opinions for this question?'); ?></h3>

<?php $this->widget('application.modules.comment.widgets.CommentFormWidget', array('redirectTo' => $this->createUrl('/feedback/contact/faqView/', array('id' => $model->id)), 'model' => $model, 'modelId' => $model->id)); ?>



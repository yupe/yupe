<?php $this->pageTitle = $model->theme; ?>
<?php $this->keywords = implode(',', explode(' ', $model->theme)); ?>

<?php
$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'FAQ') => ['/feedback/contact/faq/'],
    $model->theme,
];
?>

<h1>
    <?php echo $model->theme; ?> #<?php echo $model->id; ?>
    <?php echo CHtml::link(
        Yii::t('FeedbackModule.feedback', 'Add question ?'),
        Yii::app()->createUrl('/feedback/contact/index/'),
        ['class' => 'btn btn-info']
    ); ?>
</h1>

<?php $this->widget(
    'bootstrap.widgets.TbDetailView',
    [
        'data'       => $model,
        'attributes' => [
            'creation_date',
            'name',
            'theme',
            [
                'name'  => 'text',
                'type'  => 'raw',
                'value' => $model->text,
            ],
            [
                'name'  => 'type',
                'value' => $model->getType()
            ],
            [
                'name'  => 'answer_user',
                'value' => $model->getAnsweredUser()->getFullName()
            ],
            'answer_date',
            [
                'name' => 'answer',
                'type' => 'raw'
            ],
        ],
    ]
); ?>

<br/><br/>

<?php $this->widget(
    'application.modules.comment.widgets.CommentsListWidget',
    ['label' => Yii::t('FeedbackModule.feedback', 'Opinions'), 'model' => $model, 'modelId' => $model->id]
); ?>

<br/>

<h3><?php echo Yii::t('FeedbackModule.feedback', 'Do you have your own opinions for this question?'); ?></h3>

<?php $this->widget(
    'application.modules.comment.widgets.CommentFormWidget',
    [
        'redirectTo' => $this->createUrl('/feedback/contact/faqView/', ['id' => $model->id]),
        'model'      => $model,
        'modelId'    => $model->id
    ]
); ?>

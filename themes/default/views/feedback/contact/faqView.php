<?php $this->title = $model->theme; ?>
<?php $this->metaKeywords = implode(',', explode(' ', $model->theme)); ?>

<?php
$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'FAQ') => ['/feedback/contact/faq/'],
    $model->theme,
];
?>

<h1>
    <?= $model->theme; ?> #<?= $model->id; ?>
    <?= CHtml::link(
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
            'create_time',
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
            'answer_time',
            [
                'name' => 'answer',
                'type' => 'raw'
            ],
        ],
    ]
); ?>

<br/><br/>

<h3><?= Yii::t('FeedbackModule.feedback', 'Do you have your own opinions for this question?'); ?></h3>

<?php $this->widget('application.modules.comment.widgets.CommentsWidget', [
    'model' => $model,
]);

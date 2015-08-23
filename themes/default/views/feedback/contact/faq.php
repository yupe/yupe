<?php $this->title = [Yii::t('FeedbackModule.feedback', 'FAQ'), Yii::app()->getModule('yupe')->siteName]; ?>

<?php
$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'Contacts') => ['/feedback/contact/index'],
    Yii::t('FeedbackModule.feedback', 'FAQ'),
];
?>

<h1>
    <?= Yii::t('FeedbackModule.feedback', 'FAQ') ?>
    <?= CHtml::link(
        Yii::t('FeedbackModule.feedback', 'Add question ?'),
        Yii::app()->createUrl('/feedback/contact/index/'),
        ['class' => 'btn btn-info']
    ); ?>
</h1>

<?php $this->widget(
    'bootstrap.widgets.TbListView',
    [
        'dataProvider' => $dataProvider,
        'itemView'     => '_item',
    ]
); ?>

<?php $this->title = $model->theme; ?>
<?php $this->metaKeywords = implode(',', explode(' ', $model->theme)); ?>

<?php
$this->breadcrumbs = [
    Yii::t('FeedbackModule.feedback', 'FAQ') => ['/feedback/contact/faq/'],
    $model->theme,
];
?>

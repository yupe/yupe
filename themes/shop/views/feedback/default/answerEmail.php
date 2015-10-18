<html>
<head>
    <title><?= Yii::t(
            'FeedbackModule.feedback',
            'Answer for your message from {site}',
            ['{site}' => Yii::app()->name]
        ); ?></title>
</head>
<body>
<?= Yii::t(
    'FeedbackModule.feedback',
    'Answer for your message from {site}',
    ['{site}' => Yii::app()->name]
); ?>
<br/><br/>

<?= Yii::t('FeedbackModule.feedback', 'You wrote'); ?> : <?= CHtml::encode($model->theme); ?><br/><br/>
<?= CHtml::encode($model->text); ?><br/><br/>

<?= Yii::t('FeedbackModule.feedback', 'Our answer'); ?>: <?= $model->answer; ?><br/><br/>

<br/>
<?= Yii::t(
    'FeedbackModule.feedback',
    'Best regards, administration of "{site}"!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

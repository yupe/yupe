<html>
<head>
    <title><?= Yii::t(
            'FeedbackModule.feedback',
            'Feedback on {site} !',
            ['{site}' => CHtml::encode(Yii::app()->name)]
        ); ?></title>
</head>
<body>

<?= Yii::t(
    'FeedbackModule.feedback',
    '{name}, Your message was created, thanks!',
    ['{name}' => $model->getName()]
); ?>

<br/><br/>

<?= Yii::t('FeedbackModule.feedback', 'We answer to you soon. Thanks.'); ?>

<br/></br>

<br/></br>

<?= Yii::t(
    'FeedbackModule.feedback',
    'Best regards, administration of "{site}"!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

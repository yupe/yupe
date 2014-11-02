<html>
<head>
    <title><?php echo Yii::t(
            'FeedbackModule.feedback',
            'Feedback on {site} !',
            array('{site}' => CHtml::encode(Yii::app()->name))
        ); ?></title>
</head>
<body>

<?php echo Yii::t(
    'FeedbackModule.feedback',
    '{name}, Your message was created, thanks!',
    array('{name}' => $model->getName())
); ?>

<br/><br/>

<?php echo Yii::t('FeedbackModule.feedback', 'We answer to you soon. Thanks.'); ?>

<br/></br>

<br/></br>

<?php echo Yii::t(
    'FeedbackModule.feedback',
    'Best regards, administration of "{site}"!',
    array('{site}' => CHtml::encode(Yii::app()->name))
); ?>
</body>
</html>

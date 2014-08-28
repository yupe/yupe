<html>
<head>
    <title><?php echo Yii::t(
            'FeedbackModule.feedback',
            'Answer for your message from {site}',
            array('{site}' => Yii::app()->name)
        ); ?></title>
</head>
<body>
<?php echo Yii::t(
    'FeedbackModule.feedback',
    'Answer for your message from {site}',
    array('{site}' => Yii::app()->name)
); ?>
<br/><br/>

<?php echo Yii::t('FeedbackModule.feedback', 'You wrote'); ?> : <?php echo CHtml::encode($model->theme); ?><br/><br/>
<?php echo CHtml::encode($model->text); ?><br/><br/>

<?php echo Yii::t('FeedbackModule.feedback', 'Our answer'); ?>: <?php echo $model->answer; ?><br/><br/>

<br/>
<?php echo Yii::t(
    'FeedbackModule.feedback',
    'Best regards, administration of "{site}"!',
    array('{site}' => CHtml::encode(Yii::app()->name))
); ?>
</body>
</html>

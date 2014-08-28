<html>
<head>
    <title><?php echo Yii::t('FeedbackModule.feedback', 'New message from site'); ?> <?php echo CHtml::encode(
            Yii::app()->name
        ); ?>!</title>
</head>
<body>
<?php echo Yii::t('FeedbackModule.feedback', 'New message from site was received'); ?> <?php echo CHtml::encode(
    Yii::app()->name
); ?>!
<br/>

<?php echo Yii::t('FeedbackModule.feedback', 'Author:'); ?> <?php echo $model->name ?> - <?php echo $model->email; ?>
<br/>
<?php echo Yii::t('FeedbackModule.feedback', 'Topic:'); ?> <?php echo $model->theme; ?><br/>
<?php echo Yii::t('FeedbackModule.feedback', 'Text:'); ?> <?php echo $model->text; ?><br/>

<br/><br/>

<?php echo Yii::t(
    'FeedbackModule.feedback',
    'You can reply to this message from administration control panel, or you can answer for this message'
); ?>

<br/><br/>
<?php echo Yii::t('FeedbackModule.feedback', 'Best regards, administration'); ?> <?php echo CHtml::encode(
    Yii::app()->name
); ?> !
</body>
</html>

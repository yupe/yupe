<html>
<head>
    <title><?php echo Yii::t(
            'FeedbackModule.feedback',
            'Reply on message {site}',
            ['{site}' => Yii::app()->name]
        ); ?></title>
</head>
<body>
<?php echo Yii::t('FeedbackModule.feedback', 'Reply on message {site}', ['{site}' => Yii::app()->name]); ?>
<br/><br/>

<?php echo Yii::t('FeedbackModule.feedback', 'You wrote'); ?> : <?php echo CHtml::encode($model->theme); ?><br/><br/>
<?php echo CHtml::encode($model->text); ?><br/><br/>

<?php echo Yii::t('FeedbackModule.feedback', 'Our Reply'); ?>: <?php echo $model->answer; ?><br/><br/>

<br/>
<?php echo Yii::t(
    'FeedbackModule.feedback',
    'Truly yours {site} administration!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

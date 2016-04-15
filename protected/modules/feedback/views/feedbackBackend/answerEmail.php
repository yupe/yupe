<html>
<head>
    <title><?=  Yii::t(
            'FeedbackModule.feedback',
            'Reply on message {site}',
            ['{site}' => Yii::app()->name]
        ); ?></title>
</head>
<body>
<?=  Yii::t('FeedbackModule.feedback', 'Reply on message {site}', ['{site}' => Yii::app()->name]); ?>
<br/><br/>

<?=  Yii::t('FeedbackModule.feedback', 'You wrote'); ?> : <?=  CHtml::encode($model->theme); ?><br/><br/>
<?=  CHtml::encode($model->text); ?><br/><br/>

<?=  Yii::t('FeedbackModule.feedback', 'Our Reply'); ?>: <?=  $model->answer; ?><br/><br/>

<br/>
<?=  Yii::t(
    'FeedbackModule.feedback',
    'Truly yours {site} administration!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

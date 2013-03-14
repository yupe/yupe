<html>
<head>
    <title><?php echo Yii::t('FeedbackModule.feedback', 'Ответ на ваше сообщение   {site}', array('{site}' => Yii::app()->name)); ?></title>
</head>
<body>
    <?php echo Yii::t('FeedbackModule.feedback', 'Ответ на ваше сообщение   {site}', array('{site}' => Yii::app()->name)); ?>
    <br/><br/>

    <?php echo Yii::t('FeedbackModule.feedback','Вы писали'); ?> : <?php echo CHtml::encode($model->theme); ?><br/><br/>
    <?php echo CHtml::encode($model->text); ?><br/><br/>

    <?php echo Yii::t('FeedbackModule.feedback', 'Наш ответ'); ?>: <?php echo $model->answer; ?><br/><br/>

    <br/>
    <?php echo Yii::t('FeedbackModule.feedback', 'С уважением, администрация сайта {site} !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</body>
</html>  
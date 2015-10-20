<html>
<head>
    <title><?= Yii::t('FeedbackModule.feedback', 'New message from site'); ?> <?= CHtml::encode(
            Yii::app()->name
        ); ?>!</title>
</head>
<body>
<?= Yii::t('FeedbackModule.feedback', 'New message from site was received'); ?> <?= CHtml::encode(
    Yii::app()->name
); ?>!
<br/>

<?= Yii::t('FeedbackModule.feedback', 'Author:'); ?> <?= $model->name ?> - <?= $model->email; ?>
<br/>
<?= Yii::t('FeedbackModule.feedback', 'Topic:'); ?> <?= $model->theme; ?><br/>
<?= Yii::t('FeedbackModule.feedback', 'Text:'); ?> <?= $model->text; ?><br/>

<br/><br/>

<?= Yii::t(
    'FeedbackModule.feedback',
    'You can reply to this message from administration control panel, or you can answer for this message'
); ?>

<br/><br/>
<?= Yii::t('FeedbackModule.feedback', 'Best regards, administration'); ?> <?= CHtml::encode(
    Yii::app()->name
); ?> !
</body>
</html>

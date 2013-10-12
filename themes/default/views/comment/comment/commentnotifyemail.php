<html>
<head>
    <title>Comments was created on site <?php echo CHtml::encode(Yii::app()->name);?>!</title>
</head>
<body>
New comment was created on site <?php echo CHtml::encode(Yii::app()->name);?>!
<br/>

Text: <?php echo CHtml::encode($model->text);?><br/>
Status:  <?php echo $model->getStatus();?><br/>
Send by: <?php echo $model->name?> - <?php echo $model->email;?> <br/>

<br/><br/>
Best regards, administration of <?php echo CHtml::encode(Yii::app()->name);?> !
</body>
</html>
<html>
<head>
    <title>Добавлен новый комментарий на сайте <?php echo CHtml::encode(Yii::app()->name);?>!</title>
</head>
<body>
Добавлен новый комментарий на сайте <?php echo CHtml::encode(Yii::app()->name);?>!
<br/>

Текст: <?php echo CHtml::encode($model->text);?><br/>
Статус:  <?php echo $model->getStatus();?><br/>
Отправитель: <?php echo $model->name?> - <?php echo $model->email;?> <br/>

<br/><br/>
С уважением, администрация сайта <?php echo CHtml::encode(Yii::app()->name);?> !
</body>
</html>
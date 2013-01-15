<html>
<head>
    <title>Новое сообщение с сайта <?php echo CHtml::encode(Yii::app()->name);?>!</title>
</head>
<body>
Получено новое обращение с сайта <?php echo CHtml::encode(Yii::app()->name);?>!
<br/>

Отправитель: <?php echo $model->name?> - <?php echo $model->email;?> <br/>
Тема: <?php echo $model->theme;?><br/>
Тип:  <?php echo $model->getType();?><br/>
Текст: <?php echo $model->text;?><br/>

<br/><br/>

Ответить на это сообщения можно из панели управления сайтом или просто ответив на это письмо.

<br/><br/>
С уважением, администрация сайта <?php echo CHtml::encode(Yii::app()->name);?> !
</body>
</html>  
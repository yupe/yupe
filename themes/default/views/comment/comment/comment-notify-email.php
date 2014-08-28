<html>
<head>
    <title>Добавлен новый комментарий на сайте <?php echo CHtml::encode(Yii::app()->name); ?>!</title>
</head>
<body>
Добавлен новый комментарий на сайте <?php echo CHtml::encode(Yii::app()->name); ?>!
<br/>

Запись: <?php echo $model->getTargetTitleLink(); ?>

Текст: <?php echo CHtml::encode($model->text); ?><br/>
Статус:  <?php echo $model->getStatus(); ?><br/>
Отправитель: <?php echo Chtml::encode($model->name); ?> - <?php echo Chtml::encode($model->email); ?> <br/>

<br/><br/>
С уважением, администрация сайта <?php echo CHtml::encode(Yii::app()->name); ?> !
</body>
</html>

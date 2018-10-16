<html>
<head>
    <title>Новый комментарий к Вашей записи на сайте <?= CHtml::encode(Yii::app()->name); ?>!</title>
</head>
<body>
Добавлен новый комментарий на сайте <?= CHtml::encode(Yii::app()->name); ?>!
<br/>

Запись: <?= $model->getTargetTitleLink(); ?><br/>

Текст: "<?= CHtml::encode($model->text); ?>"<br/>
Отправитель: <?= Chtml::encode($model->name); ?><br/>

<br/><br/>
С уважением, администрация сайта <?= CHtml::encode(Yii::app()->name); ?> !
</body>
</html>

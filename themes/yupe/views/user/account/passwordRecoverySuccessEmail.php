<html>
<head>
    <title><?php echo Yii::t('user', 'Восстановление пароля для сайта "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?></title>
</head>
<body>

<?php echo Yii::t('user', 'Восстановление пароля для сайта "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?><br/><br/>

<?php echo Yii::t('user', 'Ваш пароль успешно изменен!');?><br/><br/>

<br/><br/>
<?php echo Yii::t('user', 'С уважением, администрация сайта "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>

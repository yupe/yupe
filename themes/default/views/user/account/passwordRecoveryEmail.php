<?php
	$url = Yii::app()-> request-> hostInfo.$this-> createUrl('account/recoveryPassword', array('code'=> $model-> code));
?>
<html>
<head>
    <title><?php echo Yii::t('user', 'Восстановление пароля для сайта {site} !',array('{site}' => CHtml::encode(Yii::app()->name)));?></title>
</head>
<body>
<?php echo Yii::t('user', 'Восстановление пароля для сайта "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?>
<br/>

<?php echo Yii::t('user', 'Кто-то, возможно Вы, запросил сброс пароля для сайта "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?><br/>
<?php echo Yii::t('user', 'Если это были не Вы - просто удалите это письмо.');?>
<br/>

<?php echo Yii::t('user', 'Для восстановления пароля, пожалуйста, перейдите по');?> <a href='<?php echo $url; ?>'><?php echo Yii::t('user', 'ссылке');?></a>

<br/>
<?php echo $url; ?>
<br/><br/>

<?php echo Yii::t('user', 'С уважением, администрация сайта {site} !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>
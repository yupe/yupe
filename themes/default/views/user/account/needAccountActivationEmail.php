<html>

<head>
    <title><?php echo Yii::t('user', 'Успешная активация аккаунта!');?></title>
</head>

<body>
	<?php echo Yii::t('user', 'Вы успешно зарегистрировались на сайте {site} !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

	<br/><br/>

	<?php echo Yii::t('user', 'Для активации аккаунта, пожалуйста, пройдите по'); ?> 
	<a href='http://<?php echo $_SERVER['HTTP_HOST'] . '/index.php/user/account/activate/key/' . $model->activate_key;?>'><?php echo Yii::t('user', 'ссылке'); ?></a>

	<br/><br/>

	http://<?php echo $_SERVER['HTTP_HOST'] . '/index.php/user/account/activate/key/' . $model->activate_key;?>

	<br/><br/>

	<?php echo Yii::t('user', 'С уважением, администрация сайта {site} !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

</body>

</html>  

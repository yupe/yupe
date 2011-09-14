<html>
	<head>
	   <title><?php echo Yii::t('user','Восстановление пароля на сайте');?> <?php echo CHtml::encode(Yii::app()->name);?>!</title>
	</head>
	<body>
        <?php echo Yii::t('user','Восстановление пароля на сайте');?> <b><?php echo CHtml::encode(Yii::app()->name);?> !</b><br />
		
        <?php echo Yii::t('user','Ваш новый пароль');?>: <?php echo $password;?><br />
		
		<?php echo Yii::t('user','Теперь вы можете');?> <a href='http://<?php echo $_SERVER['HTTP_HOST'];?>/index.php/user/account/login'><?php echo Yii::t('user','войти');?></a> !<br /><br />
		
		<?php echo Yii::t('user','С уважением, администрация сайта');?> <?php echo CHtml::encode(Yii::app()->name);?> !
	</body>
</html>
														
<html>
	<head>
		<title><?php echo Yii::t('user','Успешная активация аккаунта!');?></title>
	</head>
  <body>
    <?php echo Yii::t('user','Ваш аккаунт на сайте');?> <b><?php echo CHtml::encode(Yii::app()->name);?></b> <?php echo Yii::t('user','успешно активирован');?> !<br/><br/>
	
    <?php echo Yii::t('user','Теперь Вы можете');?> <a href='http://<?php echo $_SERVER['HTTP_HOST'];?>/index.php/user/account/login'><?php echo Yii::t('user','войти');?></a> !<br /><br />
		
	<?php echo Yii::t('user','С уважением, администрация сайта');?> <?php echo CHtml::encode(Yii::app()->name);?> !
  </body>
</html>  
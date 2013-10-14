<?php
	$url= Yii::app()-> request-> hostInfo.$this-> createUrl('account/recoveryPassword',array('code'=> $model-> code));
?>
<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Password reset on "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?></title>
</head>
<body>
<?php echo Yii::t('UserModule.user', 'Password reset on "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?>
<br/>

<?php echo Yii::t('UserModule.user', 'Someone, maybe request password reset on "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?>
<br/>
<?php echo Yii::t('UserModule.user', 'If this e-mail is not for you, just delete it.');?>
<br/>

<?php echo Yii::t('UserModule.user', 'For reset password, please go to ');?> <a href='<?php echo $url; ?>'><?php echo Yii::t('UserModule.user', 'link');?></a>
<br/>

<?php echo $url; ?>

<br/><br/>

<?php echo Yii::t('UserModule.user', 'Truly yours, administration of "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>
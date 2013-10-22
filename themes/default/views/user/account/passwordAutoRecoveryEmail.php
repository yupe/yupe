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

<?php echo Yii::t('UserModule.user', 'Someone probably requested a password reset on "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?>
<br/>
<?php echo Yii::t('UserModule.user', 'If you did not requested this email just delete it.');?>
<br/>

<?php echo Yii::t('UserModule.user', 'To reset your password please follow the link ');?> <a href='<?php echo $url; ?>'><?php echo Yii::t('UserModule.user', 'link');?></a>
<br/>

<?php echo $url; ?>

<br/><br/>

<?php echo Yii::t('UserModule.user', 'Truly yours, administration of "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>
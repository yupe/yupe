<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Password recovery for "{site}"!',array('site' => CHtml::encode(Yii::app()->name)));?></title>
</head>
<body>
<?php echo Yii::t('UserModule.user', 'Password recovery for "{site}"!',array('{site}' => CHtml::encode(Yii::app()->name)));?><br/>

<?php echo Yii::t('UserModule.user', 'Your new pasword is: {password}',array('{password}' => $password));?><br/>

<?php echo Yii::t('UserModule.user', 'Now you can');?> <a
    href='<?php echo Yii::app()-> request-> hostInfo.$this-> createUrl('account/login'); ?>'><?php echo Yii::t('UserModule.user', 'sign in');?></a>
!<br/><br/>

<?php echo Yii::t('UserModule.user', 'Truly yours, administration of "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>

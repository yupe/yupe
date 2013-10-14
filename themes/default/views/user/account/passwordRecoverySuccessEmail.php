<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Password recovery for "{site}"!',array('{site}' => CHtml::encode(Yii::app()->name)));?></title>
</head>
<body>

<?php echo Yii::t('UserModule.user', 'Password recovery for "{site}"!',array('{site}' => CHtml::encode(Yii::app()->name)));?><br/><br/>

<?php echo Yii::t('UserModule.user', 'Your password was successfully changed!');?><br/><br/>

<br/><br/>
<?php echo Yii::t('UserModule.user', 'Truly yours, administration of "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>

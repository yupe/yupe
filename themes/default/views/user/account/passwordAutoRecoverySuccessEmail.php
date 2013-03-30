<html>
<head>
    <title><?php echo Yii::t('user', 'Восстановление пароля на сайте "{site}"!',array('site' => CHtml::encode(Yii::app()->name)));?></title>
</head>
<body>
<?php echo Yii::t('user', 'Восстановление пароля на сайте "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?><br/>

<?php echo Yii::t('user', 'Ваш новый пароль : {password}',array('{password}' => $password));?><br/>

<?php echo Yii::t('user', 'Теперь вы можете');?> <a
    href='<?php echo Yii::app()-> request-> hostInfo.$this-> createUrl('account/login'); ?>'><?php echo Yii::t('user', 'войти');?></a>
!<br/><br/>

<?php echo Yii::t('user', 'С уважением, администрация сайта "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>

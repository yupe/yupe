<html>

<head>
    <title><?php echo Yii::t('UserModule.user', 'Changing e-mail');?></title>
</head>

<body>
<?php echo Yii::t('UserModule.user', 'You have successfully changed your email on "{site}"!',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

<br/><br/>

<?php
$url = Yii::app()-> request-> hostInfo.$this-> createUrl('/user/account/emailConfirm', array('token'=> $model->activate_key));
echo Yii::t('UserModule.user', 'To activate your email please follow the link ').CHtml::link(Yii::t('user', 'link'),$url);
?>

<br/><br/>

<?php  echo $url ?>

<br/><br/>

<?php echo Yii::t('UserModule.user', 'Truly yours, administration of "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

</body>

</html>

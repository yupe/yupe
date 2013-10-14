<html>

<head>
    <title><?php echo Yii::t('UserModule.user', 'Changing e-mail');?></title>
</head>

<body>
<?php echo Yii::t('UserModule.user', 'You just successfully change you e-mail on "{site}"!',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

<br/><br/>

<?php
$url = Yii::app()-> request-> hostInfo.$this-> createUrl('/user/account/emailConfirm', array('key'=> $model->activate_key));
echo Yii::t('UserModule.user', 'For e-mail activation, please, go to ').CHtml::link(Yii::t('user', 'link'),$url);
?>

<br/><br/>

<?php  echo $url ?>

<br/><br/>

<?php echo Yii::t('UserModule.user', 'Truly yours, administration of "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

</body>

</html>

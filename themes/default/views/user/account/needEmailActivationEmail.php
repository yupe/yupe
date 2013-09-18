<html>

<head>
    <title><?php echo Yii::t('user', 'Изменение email!');?></title>
</head>

<body>
<?php echo Yii::t('user', 'Вы успешно изменили email на сайте "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

<br/><br/>

<?php
$url = Yii::app()-> request-> hostInfo.$this-> createUrl('/user/account/emailConfirm', array('key'=> $model->activate_key));
echo Yii::t('user', 'Для активации email, пожалуйста, перейдите по ').CHtml::link(Yii::t('user', 'ссылке'),$url);
?>

<br/><br/>

<?php  echo $url ?>

<br/><br/>

<?php echo Yii::t('user', 'С уважением, администрация сайта "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

</body>

</html>

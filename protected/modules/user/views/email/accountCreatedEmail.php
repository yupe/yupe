<html>
<head>
    <title><?php echo Yii::t('user', 'Вы успешно зарегистрировались на сайте');?> <?php echo CHtml::encode(Yii::app()->name);?>
        !<title>
</head>
<body>
<?php echo Yii::t('user', 'Вы успешно зарегистрировались на сайте');?>
<b><?php echo CHtml::encode(Yii::app()->name);?>
    !</b>

<?php echo Yii::t('user', 'Теперь Вы можете');?> <a
    href='http://<?php echo $_SERVER['HTTP_HOST'];?>/index.php/user/account/login'>войти</a>

<br>
http://<?php echo $_SERVER['HTTP_HOST'];?>/index.php/user/account/login

<?php echo Yii::t('user', 'С уважением, администрация сайта');?> <?php echo CHtml::encode(Yii::app()->name);?>
!
</body>
</html
<html>
<head>
    <title><?php echo Yii::t('user', 'Восстановление пароля');?> <?php echo CHtml::encode(Yii::app()->name);?> !</title>
</head>
<body>
<?php echo Yii::t('user', 'Восстановление пароля для сайта');?> <b><?php echo CHtml::encode(Yii::app()->name);?></b> !
<br/>

<?php echo Yii::t('user', 'Кто-то, возможно Вы, запросил сброс пароля для сайта');?>
<b><?php echo CHtml::encode(Yii::app()->name);?></b> <?php echo Yii::t('user', 'если это были не Вы - просто удалите это письмо.');?>
<br/>

<?php echo Yii::t('user', 'Для восстановления пароля, пожалуйста, пройдите по');?> <a
        href='http://<?php echo $_SERVER['HTTP_HOST']?>/index.php/user/account/recoveryPassword/code/<?php echo $model->code;?>'><?php echo Yii::t('user', 'ссылке');?></a>

<br/>
http://<?php echo $_SERVER['HTTP_HOST']?>/index.php/user/account/recoveryPassword/code/<?php echo $model->code;?>

<br/><br/>

<?php echo Yii::t('user', 'С уважением, администрация сайта');?> <?php echo CHtml::encode(Yii::app()->name);?> !
</body>
</html>
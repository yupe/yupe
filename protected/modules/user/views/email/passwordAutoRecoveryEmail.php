<html>
<head>
    <title><?php echo Yii::t('user', 'Сброс пароля для сайта "{site}".',array('{site}' => CHtml::encode(Yii::app()->name));?></title>
</head>
<body>
<?php echo Yii::t('user', 'Сброс пароля для сайта "{site}".',array('{site}' => CHtml::encode(Yii::app()->name));?>
<br/>

<?php echo Yii::t('user', 'Кто-то, возможно Вы, запросил сброс пароля для сайта "{site}".',array('{site}' => CHtml::encode(Yii::app()->name)));?>
<br/>
<?php echo Yii::t('user', 'Если это были не Вы - просто удалите это письмо.');?>
<br/>

<?php echo Yii::t('user', 'Для сброса пароля,пожалуйста, перейдите по ');?> <a href='http://<?php echo $_SERVER['HTTP_HOST']?>/index.php/user/account/recoveryPassword/code/<?php echo $model->code?>'><?php echo Yii::t('user', 'ссылке');?></a>
<br/>

http://<?php echo $_SERVER['HTTP_HOST']?>/index.php/user/account/recoveryPassword/code/<?php echo $model->code;?>

<br/><br/>

<?php echo Yii::t('user', 'С уважением, администрация сайта "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>
</body>
</html>
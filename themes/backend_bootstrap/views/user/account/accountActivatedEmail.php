<html>
<head>
    <title><?php echo Yii::t('user', 'Успешная активация аккаунта!');?></title>
</head>
<body>
<?php echo Yii::t('user', 'Ваш аккаунт на сайте "{site}" успешно активирован!',array('{site}' => CHtml::encode(Yii::app()->name)));?>
<br/><br/>

<?php echo Yii::t('user', 'Теперь Вы можете');?> <a
    href='<?php echo Yii::app()-> request-> hostInfo.$this-> createUrl('account/login'); ?>'><?php echo Yii::t('user', 'войти');?></a>
!
<br/><br/>

<?php echo Yii::t('user', 'С уважением, администрация сайта "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name)));?>

</body>
</html>
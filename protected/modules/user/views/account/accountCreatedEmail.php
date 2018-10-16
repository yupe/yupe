<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Account was created!'); ?></title>
</head>
<body>
<?php echo Yii::t(
    'UserModule.user',
    'Your account on "{site}" was created successfully',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
<br/><br/>

<?php echo Yii::t('UserModule.user', 'Now You can'); ?> <a
    href='<?php echo Yii::app()->getRequest()->hostInfo . $this->createUrl('/user/account/login'); ?>'>
    <?php echo Yii::t('UserModule.user', 'login'); ?>
</a>!
<br/><br/>

<?php echo Yii::t(
    'UserModule.user',
    'Best regards, "{site}" administration!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

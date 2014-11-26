<html>
<head>
    <title><?php echo Yii::t(
            'UserModule.user',
            'Password recovery for "{site}"!',
            ['site' => CHtml::encode(Yii::app()->name)]
        ); ?></title>
</head>
<body>
<?php echo Yii::t(
    'UserModule.user',
    'Password recovery for "{site}"!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?><br/>

<?php echo Yii::t('UserModule.user', 'Your new password : {password}', ['{password}' => $password]); ?><br/>

<?php echo Yii::t('UserModule.user', 'Now you can'); ?>
<a href='<?php echo $this->createAbsoluteUrl('/user/account/login'); ?>'>
    <?php echo Yii::t('UserModule.user', 'login'); ?>
</a>!<br/><br/>

<?php echo Yii::t(
    'UserModule.user',
    'Best regards, "{site}" administration!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

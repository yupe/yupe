<html>
<head>
    <title><?=  Yii::t(
            'UserModule.user',
            'Password recovery for "{site}"!',
            ['site' => CHtml::encode(Yii::app()->name)]
        ); ?></title>
</head>
<body>
<?=  Yii::t(
    'UserModule.user',
    'Password recovery for "{site}"!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?><br/>

<?=  Yii::t('UserModule.user', 'Your new password : {password}', ['{password}' => $password]); ?><br/>

<?=  Yii::t('UserModule.user', 'Now you can'); ?>
<a href='<?=  $this->createAbsoluteUrl('/user/account/login'); ?>'>
    <?=  Yii::t('UserModule.user', 'login'); ?>
</a>!<br/><br/>

<?=  Yii::t(
    'UserModule.user',
    'Best regards, "{site}" administration!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

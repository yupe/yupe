<html>
<head>
    <title><?=  Yii::t('UserModule.user', 'Account was created!'); ?></title>
</head>
<body>
<?=  Yii::t(
    'UserModule.user',
    'Your account on "{site}" was created successfully',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
<br/><br/>

<?=  Yii::t('UserModule.user', 'Now You can'); ?> <a
    href='<?=  Yii::app()->getRequest()->hostInfo . $this->createUrl('/user/account/login'); ?>'>
    <?=  Yii::t('UserModule.user', 'login'); ?>
</a>!
<br/><br/>

<?=  Yii::t(
    'UserModule.user',
    'Best regards, "{site}" administration!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

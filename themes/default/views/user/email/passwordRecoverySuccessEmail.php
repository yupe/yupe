<html>
<head>
    <title><?= Yii::t(
            'UserModule.user',
            'Password recovery for "{site}"!',
            ['{site}' => CHtml::encode(Yii::app()->name)]
        ); ?></title>
</head>
<body>

<?= Yii::t(
    'UserModule.user',
    'Password recovery for "{site}"!',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?><br/><br/>

<?= Yii::t('UserModule.user', 'Your new password is {password} ', ['{password}' => $password]); ?><br/><br/>

<br/><br/>
<?= Yii::t(
    'UserModule.user',
    'Truly yours, administration of "{site}" !',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>
</body>
</html>

<html>

<head>
    <title><?= Yii::t('UserModule.user', 'Activation successed!'); ?></title>
</head>

<body>
<?= Yii::t(
    'UserModule.user',
    'You was successfully registered on "{site}" !',
    [
        '{site}' => CHtml::encode(
                Yii::app()->getModule('yupe')->siteName
            )
    ]
); ?>

<br/><br/>

<?= Yii::t('UserModule.user', 'To activate your account please go to ') . CHtml::link(
        Yii::t('UserModule.user', 'link'),
        $link = Yii::app()->createAbsoluteUrl(
            '/user/account/activate',
            [
                'token' => $token->token
            ]
        )
    ); ?>

<br/><br/>

<?= $link; ?>

<br/><br/>

<?= Yii::t(
    'UserModule.user',
    'Truly yours, administration of "{site}" !',
    [
        '{site}' => CHtml::encode(
                Yii::app()->getModule('yupe')->siteName
            )
    ]
); ?>

</body>

</html>

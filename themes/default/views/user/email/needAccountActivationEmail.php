<html>

<head>
    <title><?php echo Yii::t('UserModule.user', 'Activation successed!'); ?></title>
</head>

<body>
<?php echo Yii::t(
    'UserModule.user',
    'You was successfully registered on "{site}" !',
    array(
        '{site}' => CHtml::encode(
                Yii::app()->getModule('yupe')->siteName
            )
    )
); ?>

<br/><br/>

<?php echo Yii::t('UserModule.user', 'To activate your account please go to ') . CHtml::link(
        Yii::t('UserModule.user', 'link'),
        $link = Yii::app()->createAbsoluteUrl(
            '/user/account/activate',
            array(
                'token' => $token->token
            )
        )
    ); ?>

<br/><br/>

<?php echo $link; ?>

<br/><br/>

<?php echo Yii::t(
    'UserModule.user',
    'Truly yours, administration of "{site}" !',
    array(
        '{site}' => CHtml::encode(
                Yii::app()->getModule('yupe')->siteName
            )
    )
); ?>

</body>

</html>

<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Activation successed!'); ?></title>
</head>
<body>
<?php echo Yii::t(
    'UserModule.user',
    'You successfully registered on "{site}" !',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>

<br/><br/>

<?php echo Yii::t('UserModule.user', 'For account activation, click the'); ?>
<?php echo CHtml::link(
    Yii::t('UserModule.user', 'link'),
    $link = Yii::app()->createAbsoluteUrl(
        '/user/account/activate',
        [
            'key' => $model->reg->genActivateCode()
        ]
    )
); ?>
<br/><br/>

<?php echo $link; ?>

<br/><br/>

<?php echo Yii::t(
    'UserModule.user',
    'Best regards, "{site}" administration!',
    [
        '{site}' => CHtml::encode(Yii::app()->name)
    ]
); ?>
</body>
</html>

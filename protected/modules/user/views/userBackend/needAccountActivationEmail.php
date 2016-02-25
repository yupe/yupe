<html>
<head>
    <title><?=  Yii::t('UserModule.user', 'Activation successed!'); ?></title>
</head>
<body>
<?=  Yii::t(
    'UserModule.user',
    'You successfully registered on "{site}" !',
    ['{site}' => CHtml::encode(Yii::app()->name)]
); ?>

<br/><br/>

<?=  Yii::t('UserModule.user', 'For account activation, click the'); ?>
<?=  CHtml::link(
    Yii::t('UserModule.user', 'link'),
    $link = Yii::app()->createAbsoluteUrl(
        '/user/account/activate',
        [
            'key' => $model->reg->genActivateCode()
        ]
    )
); ?>
<br/><br/>

<?=  $link; ?>

<br/><br/>

<?=  Yii::t(
    'UserModule.user',
    'Best regards, "{site}" administration!',
    [
        '{site}' => CHtml::encode(Yii::app()->name)
    ]
); ?>
</body>
</html>

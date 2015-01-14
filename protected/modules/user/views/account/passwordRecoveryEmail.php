<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?php echo Yii::t(
            'UserModule.user',
            'Reset password for site "{site}"',
            [
                '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
            ]
        ); ?>
    </title>
</head>
<body>
<p>
    <?php echo Yii::t(
        'UserModule.user',
        'Reset password for site "{site}"',
        [
            '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
        ]
    ); ?>
</p>

<p>
    <?php echo Yii::t(
        'UserModule.user',
        'Somewho, maybe you request password recovery for "{site}"',
        [
            '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
        ]
    ); ?>
</p>

<p>
    <?php echo Yii::t('UserModule.user', 'Just remove this letter if it addressed not for you.'); ?>
</p>

<p>
    <?php echo Yii::t(
        'UserModule.user',
        'For password recovery, please follow this :link',
        [
            ':link' => CHtml::link(
                    Yii::t('UserModule.user', 'link'),
                    $link = $this->createAbsoluteUrl(
                        '/user/account/restore',
                        [
                            'token' => $model->recovery->genActivateCode(),
                        ]
                    )
                ),
        ]
    ); ?>
</p>

<p><?php echo $link; ?></p>

<hr/>

<?php echo Yii::t(
    'UserModule.user',
    'Best regards, "{site}" administration!',
    [
        '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
    ]
); ?>
</body>
</html>

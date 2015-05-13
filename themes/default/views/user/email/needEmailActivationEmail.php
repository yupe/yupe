<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        <?= Yii::t('UserModule.user', 'Changing e-mail'); ?>
    </title>
</head>
<body>
<p>
    <?= Yii::t(
        'UserModule.user',
        'You have successfully changed your email on "{site}"!',
        [
            '{site}' => CHtml::encode(
                    Yii::app()->getModule('yupe')->siteName
                )
        ]
    ); ?>
</p>

<p>
    <?= Yii::t(
        'UserModule.user',
        'To activate your email please follow the {link}',
        [
            '{link}' => CHtml::link(
                    Yii::t('UserModule.user', 'link'),
                    $link = $this->createAbsoluteUrl(
                        '/user/account/confirm',
                        [
                            'token' => $token->token
                        ]
                    )
                )
        ]
    ); ?>
</p>

<p><?= $link; ?></p>

<hr/>

<p>
    <?= Yii::t(
        'UserModule.user',
        'Truly yours, administration of "{site}" !',
        [
            '{site}' => CHtml::encode(
                    Yii::app()->getModule('yupe')->siteName
                )
        ]
    ); ?>
</p>
</body>
</html>

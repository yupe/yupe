<!doctype html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>
            <?php echo Yii::t(
                'UserModule.user', 'Reset password for site "{site}"', array(
                    '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
                )
            ); ?>
        </title>
    </head>
    <body>
        <p>
            <?php echo Yii::t(
                'UserModule.user', 'Reset password for site "{site}"', array(
                    '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
                )
            ); ?>
        </p>
        <p>
            <?php echo Yii::t(
                'UserModule.user', 'Somewho, maybe you request password recovery for "{site}"', array(
                    '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
                )
            ); ?>
        </p>
        <p>
            <?php echo Yii::t('UserModule.user', 'Just remove this letter if it addressed not for you.'); ?>
        </p>
        <p>
            <?php echo Yii::t(
                'UserModule.user', 'Your new password is ":password"', array(
                    ':password' => $password
                )
            ); ?>
        </p>
        <p>
            <?php echo Yii::t(
                'UserModule.user', 'For login in, please follow this :link', array(
                    ':link' => CHtml::link(
                        Yii::t('UserModule.user', 'link'),
                        $this->createAbsoluteUrl('/user/account/login')
                    ),
                )
            ); ?>
        </p>

        <hr />
        
        <p>
            <?php echo Yii::t(
                'UserModule.user', 'Best regards, "{site}" administration!', array(
                    '{site}' => CHtml::encode(Yii::app()->getModule('yupe')->siteName)
                )
            ); ?>
        </p>
    </body>
</html>
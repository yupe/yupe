<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Успешная активация аккаунта!'); ?></title>
</head>
<body>
    <?php echo Yii::t('UserModule.user', 'Ваш аккаунт на сайте "{site}" успешно активирован!', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
    <br/><br/>

    <?php echo Yii::t('UserModule.user', 'Теперь Вы можете'); ?> <a href='<?php echo Yii::app()->request->hostInfo . $this->createUrl('/user/account/login'); ?>'>
        <?php echo Yii::t('UserModule.user', 'войти'); ?>
    </a>!
    <br/><br/>

    <?php echo Yii::t('UserModule.user', 'С уважением, администрация сайта "{site}" !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</body>
</html>
<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Восстановление пароля на сайте "{site}"!', array('site' => CHtml::encode(Yii::app()->name))); ?></title>
</head>
<body>
    <?php echo Yii::t('UserModule.user', 'Восстановление пароля на сайте "{site}" !', array('{site}' => CHtml::encode(Yii::app()->name))); ?><br/>

    <?php echo Yii::t('UserModule.user', 'Ваш новый пароль : {password}', array('{password}' => $password)); ?><br/>

    <?php echo Yii::t('UserModule.user', 'Теперь вы можете'); ?>
    <a href='<?php echo Yii::app()->request->hostInfo.$this->createUrl('/user/account/login'); ?>'>
        <?php echo Yii::t('UserModule.user', 'войти'); ?>
    </a>!<br/><br/>

    <?php echo Yii::t('UserModule.user', 'С уважением, администрация сайта "{site}" !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</body>
</html>

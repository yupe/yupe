<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Успешная активация аккаунта!'); ?></title>
</head>
<body>
    <?php echo Yii::t('UserModule.user', 'Вы успешно зарегистрировались на сайте "{site}" !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>

    <br/><br/>

    <?php echo Yii::t('UserModule.user', 'Для активации аккаунта, пожалуйста, перейдите по'); ?>
    &nbsp;<?php echo CHtml::link(Yii::t('UserModule.user', 'ссылке'),$link=Yii::app()->createAbsoluteUrl('/user/account/activate', array('key' => $model->activate_key))); ?>
    <br/><br/>

    <?php  echo $link; ?>

    <br/><br/>

    <?php echo Yii::t('UserModule.user', 'С уважением, администрация сайта "{site}" !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</body>
</html>

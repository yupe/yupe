<?php $url= Yii::app()->request->hostInfo . $this->createUrl('/user/account/recoveryPassword', array('code'=> $model->code)); ?>
<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Reset password for site "{site}"', array('{site}' => CHtml::encode(Yii::app()->name))); ?></title>
</head>
<body>
    <?php echo Yii::t('UserModule.user', 'Reset password for site "{site}"', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
    <br/>

    <?php echo Yii::t('UserModule.user', 'Somewho, maybe you request password recovery for "{site}"', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
    <br/>
    <?php echo Yii::t('UserModule.user', 'Just remove this letter if it addressed not for you.');?>
    <br/>

    <?php echo Yii::t('UserModule.user', 'For password reset, please click'); ?> <a href='<?php echo $url; ?>'><?php echo Yii::t('UserModule.user', 'link'); ?></a>
    <br/>

    <?php echo $url; ?>

    <br/><br/>

    <?php echo Yii::t('UserModule.user', 'Best regards, "{site}" administration!', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</body>
</html>
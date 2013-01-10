<?php $url= Yii::app()->request->hostInfo . $this->createUrl('/user/account/recoveryPassword', array('code'=> $model->code)); ?>
<html>
<head>
    <title><?php echo Yii::t('UserModule.user', 'Сброс пароля для сайта "{site}".', array('{site}' => CHtml::encode(Yii::app()->name))); ?></title>
</head>
<body>
    <?php echo Yii::t('UserModule.user', 'Сброс пароля для сайта "{site}".', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
    <br/>

    <?php echo Yii::t('UserModule.user', 'Кто-то, возможно Вы, запросил сброс пароля для сайта "{site}".', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
    <br/>
    <?php echo Yii::t('UserModule.user', 'Если это были не Вы - просто удалите это письмо.');?>
    <br/>

    <?php echo Yii::t('UserModule.user', 'Для сброса пароля,пожалуйста, перейдите по '); ?> <a href='<?php echo $url; ?>'><?php echo Yii::t('UserModule.user', 'ссылке'); ?></a>
    <br/>

    <?php echo $url; ?>

    <br/><br/>

    <?php echo Yii::t('UserModule.user', 'С уважением, администрация сайта "{site}" !', array('{site}' => CHtml::encode(Yii::app()->name))); ?>
</body>
</html>
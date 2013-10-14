<html>

<head>
    <title><?php echo Yii::t('UserModule.user', 'Activation success!');?></title>
</head>

<body>
	<?php echo Yii::t('UserModule.user', 'You was successfully registered on "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

	<br/><br/>

	<?php
        $url = Yii::app()-> request-> hostInfo.$this-> createUrl('/user/account/activate', array('key'=> $model->activate_key));
        echo Yii::t('UserModule.user', 'For activate your account please go to ').CHtml::link(Yii::t('UserModule.user', 'link'),$url);
    ?>

	<br/><br/>

	<?php  echo $url ?>

	<br/><br/>

	<?php echo Yii::t('UserModule.user', 'Truly yours, administration of "{site}" !',array('{site}' => CHtml::encode(Yii::app()->name))); ?>

</body>

</html>

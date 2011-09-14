<?php echo Yii::t('user', 'Вы успешно зарегистрировались на сайте'); ?>
<b><?php echo CHtml::encode(Yii::app()->name);?></b> !

<br/><br/>

<?php echo Yii::t('user', 'Для активации аккаунта, пожалуйста, пройдите по'); ?> <a
        href='http://<?php echo $_SERVER['HTTP_HOST'] . '/index.php/user/account/activate/code/' . $model->code . '/email/' . $model->email;?>'><?php echo Yii::t('user', 'ссылке'); ?></a>

<br/><br/>

http://<?php echo $_SERVER['HTTP_HOST'] . '/index.php/user/account/activate/code/' . $model->code . '/email/' . $model->email; ?>

<br/><br/>

<?php echo Yii::t('user', 'С уважением, администрация сайта'); ?> <?php echo CHtml::encode(Yii::app()->name); ?> !


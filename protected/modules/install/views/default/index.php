<h1><?php echo Yii::t('yupe', 'Добро пожаловать!');?></h1>

<p><?php echo Yii::t('yupe', 'Теперь вы сможете очень легко и просто запустить Ваш сайт или блог на "<b>{app}</b>"', array('{app}' => Yii::app()->name));?></p>
<p><?php echo Yii::t('yupe', 'Просто следуйте инструкциям установщика');?></p>

<?php echo CHtml::beginForm(array('default/requirements'), 'get'); ?>
<?php echo CHtml::submitButton('Продолжить >>>'); ?>
<?php echo CHtml::endForm(); ?>   


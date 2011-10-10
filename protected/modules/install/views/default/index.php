<h1><?php echo Yii::t('yupe', 'Добро пожаловать!');?></h1>

<p><?php echo Yii::t('yupe', 'Используя этот установщик, Вы сможете очень легко и просто запустить Ваш сайт или блог на "<b>{app}</b>"', array('{app}' => Yii::app()->name));?></p>

<?php echo CHtml::beginForm(array('default/requirements'), 'get'); ?>
<?php echo CHtml::submitButton('Продолжить >>>'); ?>
<?php echo CHtml::endForm(); ?>   


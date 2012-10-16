<h1><?php echo Yii::t('install', 'Добро пожаловать!'); ?></h1>

<p><?php echo Yii::t('install', 'Теперь вы сможете очень легко и просто запустить Ваш сайт или блог на "<b>{app}</b>"', array('{app}' => Yii::app()->name)); ?></p>
<p><?php echo Yii::t('install', 'Просто следуйте инструкциям установщика'); ?></p>

<?php $this->widget('bootstrap.widgets.TbButton', array(
     'type'  => 'primary',
     'label' => Yii::t('install', 'Продолжить >'),
     'url'   => array('default/requirements'),
 )); ?>
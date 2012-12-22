<h1><?php echo Yii::t('install', 'Добро пожаловать!'); ?></h1>

<p><?php echo Yii::t('install', 'Теперь вы сможете очень легко и просто запустить Ваш сайт или блог на "<b>{app}</b>"', array('{app}' => Yii::app()->name)); ?></p>
<p><?php echo Yii::t('install', 'Просто следуйте инструкциям установщика и все у Вас получиться!'); ?></p>
<p><?php echo Yii::t('install', 'Мы всегда рады видеть Вас на нашем сайте {link} !',array('{link}' => CHtml::link('http://yupe.ru','http://yupe.ru?from=install'))); ?></p>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'  => 'primary',
    'label' => Yii::t('install', 'Продолжить >'),
    'url'   => array('/install/default/environment'),
)); ?>
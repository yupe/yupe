<h1><?php echo Yii::t('install', 'Добро пожаловать!'); ?></h1>

<p><?php echo Yii::t('install', 'Теперь вы сможете очень легко и просто запустить Ваш сайт или блог на "<b>{app}</b>"', array('{app}' => Yii::app()->name)); ?></p>
<p><?php echo Yii::t('install', 'Просто следуйте инструкциям установщика и все у Вас получиться!'); ?></p>
<p><?php echo Yii::t('install', 'Мы всегда рады видеть Вас на нашем сайте {link}, а еще у нас есть {twitter} !',array('{twitter}' => CHtml::link('твиттер','http://twitter.com/yupecms',array('target' => '_blank')),'{link}' => CHtml::link('http://yupe.ru','http://yupe.ru?from=install',array('target' => '_blank')))); ?></p>

<?php $this->widget('bootstrap.widgets.TbButton', array(
    'type'  => 'primary',
    'label' => Yii::t('install', 'Начать установку >'),
    'url'   => array('/install/default/environment'),
)); ?>
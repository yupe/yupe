<?php $this->pageTitle = Yii::t('user', 'Восстановление пароля'); ?>

<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Восстановление пароля'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Управлением восстановлениями пароля'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('user', 'Восстановление пароля');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>

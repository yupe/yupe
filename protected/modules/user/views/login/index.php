<?php
$this->breadcrumbs = array(
    Yii::t('user', 'Пользователи') => array('/user/default/admin/'),
    Yii::t('user', 'Авторизационные данные'),
);

$this->menu = array(
    array('label' => Yii::t('user', 'Управление'), 'url' => array('admin')),
);
?>

<h1><?php echo Yii::t('user', 'Авторизационные данные');?></h1>

<?php $this->widget('zii.widgets.CListView', array(
                                                  'dataProvider' => $dataProvider,
                                                  'itemView' => '_view',
                                             )); ?>

<?php 
    $this->pageTitle = Yii::t('user', 'Пользователи');
    $this->breadcrumbs = array(
        Yii::t('user', 'Пользователи'),
    );
    
    $this->menu = array(
        array('label' => Yii::t('user', 'Добавление пользователя'), 'url' => array('create')),
        array('label' => Yii::t('user', 'Управление пользователями'), 'url' => array('admin')),
    );
?>

<h1><?=Yii::t('user', 'Пользователи');?></h1>

<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    )); 
 ?>

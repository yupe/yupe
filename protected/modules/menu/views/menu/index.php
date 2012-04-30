<?php
    $this->breadcrumbs = array(
        Yii::t('menu', 'Меню'),
    );
    
    $this->menu = array(
        array('label'=>Yii::t('menu', 'Добавить меню'), 'url'=>array('create')),
        array('label'=>Yii::t('menu', 'Управление меню'), 'url'=>array('admin')),
        array('label'=>Yii::t('menu', 'Добавить пункт меню'), 'url'=>array('addMenuItem')),
    );
?>

<h1><?=Yii::t('menu', 'Меню')?></h1>

<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
    ));
?>

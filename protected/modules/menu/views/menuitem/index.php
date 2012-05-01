<?php
    $this->breadcrumbs = array(
        Yii::t('menu', 'Меню')=>array('admin'),
        Yii::t('menu', 'Пункты меню')=>array('adminMenuItem'),
        Yii::t('menu', 'Cписок пунктов меню'),
    );

    $this->menu = array(
        array('label'=>Yii::t('menu', 'Меню')),
        array('label'=>Yii::t('menu', 'Добавить меню'), 'url'=>array('create')),
        array('label'=>Yii::t('menu', 'Список меню'), 'url'=>array('index')),
        array('label'=>Yii::t('menu', 'Управление меню'), 'url'=>array('admin')),

        array('label'=>Yii::t('menu', 'Пункты меню')),
        array('label'=>Yii::t('menu', 'Добавить пункт меню'), 'url'=>array('addMenuItem')),
        array('label'=>Yii::t('menu', 'Управление пунктами меню'), 'url'=>array('adminMenuItem')),
    );

?>

<h1><?=Yii::t('menu', 'Пункты меню')?></h1>

<?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'../menuitem/_view',
    ));
?>

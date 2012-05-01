<?php
    $this->breadcrumbs = array(
        Yii::t('menu', 'Меню')=>array('admin'),
        Yii::t('menu', 'Пункты меню')=>array('adminMenuItem'),
        $model->title=>array('viewMenuItem', 'id'=>$model->id),
        Yii::t('menu', 'Редактирование'),
    );

    $this->menu = array(
        array('label'=>Yii::t('menu', 'Меню')),
        array('label'=>Yii::t('menu', 'Добавить меню'), 'url'=>array('create')),
        array('label'=>Yii::t('menu', 'Список меню'), 'url'=>array('index')),
        array('label'=>Yii::t('menu', 'Управление меню'), 'url'=>array('admin')),

        array('label'=>Yii::t('menu', 'Пункты меню')),
        array('label'=>Yii::t('menu', 'Добавить пункт меню'), 'url'=>array('addMenuItem')),
        array('label'=>Yii::t('menu', 'Просмотр пункта меню'), 'url'=>array('viewMenuItem', 'id'=>$model->id)),
        array('label'=>Yii::t('menu', 'Cписок пунктов меню'), 'url'=>array('indexMenuItem')),
        array('label'=>Yii::t('menu', 'Управление пунктами меню'), 'url'=>array('adminMenuItem')),
    );
?>

<h1><?=Yii::t('menu', 'Редактирование пункта меню')?> "<?=$model->title?>"</h1>

<?=$this->renderPartial('../menuitem/_form', array('model'=>$model))?>
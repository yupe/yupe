<?php
    $this->breadcrumbs = array(
        Yii::t('menu', 'Меню')=>array('admin'),
        $model->name,
    );

    $this->menu = array(
        array('label'=>Yii::t('menu', 'Меню')),
        array('label'=>Yii::t('menu', 'Добавить меню'), 'url'=>array('create')),
        array('label'=>Yii::t('menu', 'Изменить меню'), 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>Yii::t('menu', 'Удалить меню'), 'url'=>'#', 'linkOptions'=>array(
            'submit'=>array('delete', 'id'=>$model->id),
            'confirm'=>Yii::t('menu', 'Подтверждаете удаление?')),
        ),
        array('label'=>Yii::t('menu', 'Список меню'), 'url'=>array('index')),
        array('label'=>Yii::t('menu', 'Управление меню'), 'url'=>array('admin')),
        
        array('label'=>Yii::t('menu', 'Пункты меню')),
        array('label'=>Yii::t('menu', 'Добавить пункт меню'), 'url'=>array('addMenuItem')),
        array('label'=>Yii::t('menu', 'Cписок пунктов меню'), 'url'=>array('indexMenuItem')),
        array('label'=>Yii::t('menu', 'Управление пунктами меню'), 'url'=>array('adminMenuItem')),
    );
?>

<h1><?=Yii::t('menu', 'Просмотр меню')?> "<?=$model->name?>"</h1>

<?php
    $this->widget('zii.widgets.CDetailView', array(
        'data'=>$model,
        'attributes'=>array(
            'id',
            'name',
            'code',
            'description',
            array(
                'name'=>'status',
                'value'=>$model->getStatus(),
            ),
        ),
    ));
?>